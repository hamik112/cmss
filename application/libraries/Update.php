<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 16.08.14
 * Time: 18:04
 */

/*
 * Set the script max execution time
 */
@ini_set('max_execution_time', 120);

class AutoUpdate {
    /*
     * Enable logging
     */
    private $_log = false;

    /*
     * Log Dir
     */
    private $logDir = UPDATE_DIR_LOGS;

    /*
     * Log file
     */
    public $logFile = 'updatelog.txt';

    /*
     * The last error
     */
    private $_lastError = null;

    /*
     * Current version
     */
    public $currentVersion = 0;

    /*
     * License Key
     */
    public $licensekey = null;

    /*
     * Name of the latest version
     */
    public $latestVersionName = '';

    /*
     * The latest version
     */
    public $latestVersion = null;

    /*
     * Url to the latest version of the update
     */
    public $latestUpdate = null;

    /*
     * Url to the latest changelogs of the update
     */
    public $latestChangelog = null;

    /*
     * Url to the update folder on the server
     */
    public $updateUrl = update_url;

    /*
     * Update Channel
     */
    public $updateChannel = update_channel;

    /*
     * Version filename on the server
     */
    public $updateIni = 'update';

    /*
     * Temporary download directory
     */
    public $tempDir = UPDATE_DIR_TEMP;

    /*
     * Remove temprary directory after installation
     */
    public $removeTempDir = true;

    /*
     * Install directory
     */
    public $installDir = UPDATE_DIR_INSTALL;

    /*
     * Create new folders with this privileges
     */
    public $dirPermissions = 0755;

    /*
     * Update script filename
     */
    public $updateScriptName = '_upgrade.php';

    /*
     * Create new instance
     *
     * @param bool $log Default: false
     */
    public function __construct($log = false) {
        $this->_log = $log;

        if( logging == false ) {
            $this->_log = false;
        }
    }

    /*
     * Log a message if logging is enabled
     *
     * @param string $message The message
     *
     * @return void
     */
    public function log($message) {
        if ($this->_log) {
            $this->_lastError = $message;

            $log = fopen($this->logDir.$this->logFile, 'a');

            if ($log) {
                $message = date('<'.date_format.'>').$message."\n";
                fputs($log, $message);
                fclose($log);
            }
            else {
                die('Could not write log file!');
            }
        }
    }

    /*
     * Get the latest error
     *
     * @return string Last error
     */
    public function getLastError() {
        if (!is_null($this->_lastError))
            return $this->_lastError;
        else
            return false;
    }

    private function _removeDir($dir) {
        if (@is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir.DS.$object) == "dir")
                        $this->_removeDir($dir.DS.$object);
                    else
                        unlink($dir.DS.$object);
                }
            }
            reset($objects);

            if( $dir != $this->tempDir && $dir != $this->tempDir.DS ) {
                rmdir($dir);
            }
        }
    }

    private function _file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /*
     * Check for a new version
     *
     * @return string The latest version
     */
    public function checkUpdate() {
        $this->log('Checking for a new update. . .');

        if( $this->licensekey != null ) {
            $updateFile = $this->updateUrl.'/'.$this->updateIni.'?license-key='.urlencode($this->licensekey).'&domain='.urlencode(site_url()).'&channel='.urlencode($this->updateChannel);
        } else {
            $updateFile = $this->updateUrl.'/'.$this->updateIni;
        }

        //$update = @file_get_contents($updateFile);
        $update = $this->_file_get_contents_curl($updateFile);
        if ($update === false) {
            $this->log('Could not retrieve update file `'.$updateFile.'`!');
            return false;
        } else {

            if( !function_exists('parse_ini_string') ) {
                $this->log('parse_ini_string is not supported your PHP Version is '.phpversion());
                return false;
            }

            $versions = parse_ini_string($update, true);
            if (is_array($versions)) {
                $keyOld = 0;
                $latest = 0;
                $update = '';
                $changelog = null;

                foreach ($versions as $key => $version) {
                    if ($key > $keyOld) {
                        $keyOld = $key;
                        $latest = $version['version'];
                        $update = $version['url'];
                        $changelog = $version['changelog'];
                    }
                }

                $this->log('New version found `'.$latest.'`.');
                $this->latestVersion = $keyOld;
                $this->latestVersionName = $latest;
                $this->latestUpdate = $update;
                $this->latestChangelog = $changelog;

                return $keyOld;
            }
            else {
                $this->log('Unable to parse update file!');
                return false;
            }
        }
    }

    /*
     * Download the update
     *
     * @param string $updateUrl Url where to download from
     * @param string $updateFile Path where to save the download
     */
    public function downloadUpdate($updateUrl, $updateFile) {
        $this->log('Downloading update...');
        //$update = @file_get_contents($updateUrl);
        $update = $this->_file_get_contents_curl($updateUrl);

        if ($update === false) {
            $this->log('Could not download update `'.$updateUrl.'`!');
            return false;
        }

        $handle = fopen($updateFile, 'w');

        if (!$handle) {
            $this->log('Could not save update file `'.$updateFile.'`!');
            return false;
        }

        if (!fwrite($handle, $update)) {
            $this->log('Could not write to update file `'.$updateFile.'`!');
            return false;
        }

        fclose($handle);

        return true;
    }

    /*
     * Install update
     *
     * @param string $updateFile Path to the update file
     */
    public function install($updateFile) {

        if( !function_exists('zip_open') ) {
            $this->log('Your System has no ZZIPlib support for PHP! You need to manually install the update!');
            return false;
        }

        $zip = zip_open($updateFile);

        while ($file = zip_read($zip)) {
            $filename = zip_entry_name($file);
            $filename = str_replace('/', DS, $filename);
            $filename = str_replace('\\', DS, $filename);
            $foldername = $this->installDir.dirname($filename);

            $this->log('Updating `'.$filename.'`!');

            // Skip Mac OS X native files
            if(
                strstr(strtolower($filename), '__macosx') ||
                strstr(strtolower($filename), 'ds_store') ||
                $filename == 'config.php'
            ) {
                $this->log('Skip `'.$filename.'`!');
                continue;
            }

            if (@!is_dir($foldername)) {
                if (!mkdir($foldername, $this->dirPermissions, true)) {
                    $this->log('Could not create folder `'.$foldername.'`!');
                }
            }

            $contents = zip_entry_read($file, zip_entry_filesize($file));

            //Skip if entry is a directory
            if (substr($filename, -1, 1) == DS)
                continue;

            //Write to file
            if (!is_writable($this->installDir.$filename) && file_exists($this->installDir.$filename)) {
                $this->log('Could not update `'.$this->installDir.$filename.'`, not writeable!');
                return false;
            }

            $updateHandle = @fopen($this->installDir.$filename, 'w+');

            if (!$updateHandle) {
                $this->log('Could not update file `'.$this->installDir.$filename.'`!');
                return false;
            }

            if (!fwrite($updateHandle, $contents)) {
                $this->log('Could not write to file `'.$this->installDir.$filename.'`!');
                return false;
            }

            fclose($updateHandle);

            //If file is a update script, include
            if ($filename == $this->updateScriptName) {
                $this->log('Try to include update script `'.$this->installDir.$filename.'`.');
                require($this->installDir.$filename);
                $this->log('Update script `'.$this->installDir.$filename.'` included!');
                unlink($this->installDir.$filename);
            }
        }

        zip_close($zip);

        if ($this->removeTempDir) {
            $this->log('Temporary directory `'.$this->tempDir.'` deleted.');
            $this->_removeDir($this->tempDir);
        }

        $this->log('Update `'.$this->latestVersion.'` installed.');

        return true;
    }


    /*
     * Update to the latest version
     */
    public function update() {
        //Check for latest version
        if ((is_null($this->latestVersion)) or (is_null($this->latestUpdate))) {
            $this->checkUpdate();
        }

        if ((is_null($this->latestVersion)) or (is_null($this->latestUpdate))) {
            return false;
        }

        //Update
        if ($this->latestVersion > $this->currentVersion) {
            $this->log('Updating...');

            //Add slash at the end of the path
            if ($this->tempDir[strlen($this->tempDir)-1] != DS);
                $this->tempDir = $this->tempDir.DS;

            if ((@!is_dir($this->tempDir)) and (!mkdir($this->tempDir, DIR_WRITE_MODE, true))) {
                $this->log('Temporary directory `'.$this->tempDir.'` does not exist and could not be created!');
                return false;
            }

            if (!is_writable($this->tempDir)) {
                $this->log('Temporary directory `'.$this->tempDir.'` is not writeable!');
                return false;
            }

            //$updateFile = $this->tempDir.'/'.$this->latestVersion.'.zip';
            $updateFile = $this->tempDir.$this->latestVersion.'.zip';

            if( $this->latestUpdate != null ) {
                $updateUrl = $this->latestUpdate;
            } else {
                $updateUrl = $this->updateUrl.'/'.$this->latestVersion.'.zip';
            }

            //Download update
            if (!is_file($updateFile)) {
                if (!$this->downloadUpdate($updateUrl, $updateFile)) {
                    $this->log('Failed to download update!');
                    return false;
                }

                $this->log('Latest update downloaded to `'.$updateFile.'`.');
            }
            else {
                $this->log('Latest update already downloaded to `'.$updateFile.'`.');
            }

            //Unzip
            return $this->install($updateFile);
        }
        else {
            $this->log('No update available!');
            return false;
        }
    }
}
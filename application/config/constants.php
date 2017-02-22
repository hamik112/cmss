<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| simpleCE Settings
|--------------------------------------------------------------------------
|
| All Settings for simpleCE
|
| Please do not change any values in this file, overwrite them in your config.php!!!
| ==================================================================================
|
*/
/**
 * non-changeable defaults
 */
define('software_name', 'simpleCE');
define('software_version', '2.2.3');
define('software_update_version', 223);
define('copyright', '<a href="https://simplece.com" target="_blank">'.software_name.' v.'.software_version.'</a> &copy; '.date('Y').' by <a href="https://www.pascal-bajorat.com" target="_blank">Pascal-Bajorat.com</a>');
define('copyright_short', '&copy; '.date('Y').' by <a href="https://www.pascal-bajorat.com" target="_blank">Pascal-Bajorat.com</a>');

if( @!ini_get('date.timezone') && defined('timezone') )
{
    @date_default_timezone_set(timezone);
}

/**
 * Logging
 */
if( ! defined('logging') ) {
    define('logging', true);
}

/**
 * Styling Defaults
 */
if( ! defined('fe_color_1') ) {
    define('fe_color_1', '#2ba6cb');
}

if( ! defined('fe_color_2') ) {
    define('fe_color_2', '#ffffff');
}

/**
 * Date Format
 * http://php.net/manual/en/function.date.php#refsect1-function.date-parameters
 */
if( ! defined('date_format') ) {
    define('date_format', 'm/d/Y - g:i a');
}

/**
 * Cache Settings
 */
if( ! defined('cache_directory') ) {
    define('cache_directory', 'cache');
}

if( ! defined('cache_ttl') ) {
    define('cache_ttl', 2592000); // 30 days
}

/**
 * Captcha Settings
 */
if( ! defined('captcha_path_web') ) {
    define('captcha_path_web', 'assets/captcha');
}

if( ! defined('captcha_path_local') ) {
    define('captcha_path_local', 'assets'.DS.'captcha');
}

if( ! defined('captcha_expiration') ) {
    define('captcha_expiration', 7200);
}

if( ! defined('captcha_font') ) {
    define('captcha_font', 'assets'.DS.'fonts'.DS.'Oswald-Regular.ttf');
}

/**
 * Custom Backend CSS
 */
if( ! defined('custom_backend_css') ) {
    define('custom_backend_css', 'custom-backend.css');
}

/**
 * Thumbnail Settings
 */
if( ! defined('thumb_quality') ) {
    define('thumb_quality', 85);
}

if( ! defined('thumb_cache_dir') ) {
    define('thumb_cache_dir', 'image-cache');
}

if( ! defined('backups_dir') ) {
    define('backups_dir', 'backups');
}

/**
 * Upload Settings
 */
if( ! defined('uploads_dir') ) {
    define('uploads_dir', 'uploads');
}

if( ! defined('allowed_images') ) {
    define('allowed_images', 'gif|jpg|png|jpeg');
}

if( ! defined('allowed_files') ) {
    define('allowed_files', '*');
}

if( ! defined('editable_files') ) {
    define('editable_files', 'php|php4|php5|html|htm|css|js|txt|json|xml');
}

/**
 * Updater Settings
 */
if( ! defined('update_url') ) {
    define('update_url', 'https://cloud.simplece.com');
}

if( ! defined('update_channel') ) {
    define('update_channel', 'production'); // beta or production
}

if( ! defined('UPDATE_DIR_TEMP') ) {
    define('UPDATE_DIR_TEMP', APPPATH.'tmp');
}

if( ! defined('UPDATE_DIR_INSTALL') ) {
    define('UPDATE_DIR_INSTALL', FCPATH);
}

if( ! defined('UPDATE_DIR_LOGS') ) {
    define('UPDATE_DIR_LOGS', APPPATH.'logs'.DS);
}

/**
 * Cookie Settings
 */
if( ! defined('cookie_domain') ) {
    define('cookie_domain', '');
}

if( ! defined('cookie_path') ) {
    define('cookie_path', '/');
}

if( ! defined('cookie_secure') ) {
    define('cookie_secure', false);
}

/**
 * Security Settings
 */
if( ! defined('encryption_key') ) {
    define('encryption_key', 'KMpPfy.x^RZTZoTB2gm)Mvwyg.qxsPeBrdrh?eJfMXV3CXddyD');
}

/**
 * Demo-Mode Setting
 */
if( ! defined('demo_mode') ) {
    define('demo_mode', false);
}

if( ! defined('demo_user') ) {
    define('demo_user', 'admin');
}

if( ! defined('demo_pw') ) {
    define('demo_pw', 'admin');
}

if( ! defined('license_key') ) {
    define('license_key', 'beta-tester');
}

/**
 * Database and Table Settings
 */
if( ! defined('db_prefix') ) {
    define('db_prefix', 'sce_');
}

if( ! defined('text_table') ) {
    define('text_table', 'text');
}

if( ! defined('image_table') ) {
    define('image_table', 'images');
}

if( ! defined('file_table') ) {
    define('file_table', 'files');
}

if( ! defined('loop_table') ) {
    define('loop_table', 'loops');
}

if( ! defined('user_table') ) {
    define('user_table', 'user');
}

if( ! defined('settings_table') ) {
    define('settings_table', 'settings');
}

if( ! defined('captcha_table') ) {
    define('captcha_table', 'captcha');
}

/* End of file constants.php */
/* Location: ./application/config/constants.php */
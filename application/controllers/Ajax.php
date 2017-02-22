<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 06/07/14
 * Time: 14:29
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class ajax extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('sce', language);
        $this->load->helper('language');

        $this->load->database();
        $this->load->model('user_model');
        $this->load->model('simplece_model');
        $this->load->model('loop_model');

        if( $this->simplece_model->get_setting_val('disable_cache', 'no') == 'no' ) {
            $this->load->driver('cache', array('adapter' => 'file'));
            define('use_cache', true);
        } else {
            define('use_cache', false);
        }
    }

    public function update_check()
    {
        if( $this->user_model->check_login() !== true ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "Access denied!"}');
            return;
        }

        require_once APPPATH.'libraries'.DS.'update.php';

        $update = new AutoUpdate(true);
        $update->currentVersion = software_update_version;
        $update->updateUrl = update_url;
        $update->licensekey = $this->simplece_model->get_setting_val('license_key');

        $latest = $update->checkUpdate();
        if ($latest !== false) {

            $this->simplece_model->update_setting('last_update_check', time());

            if ($latest > $update->currentVersion) {
                $this->output->set_content_type('application/json');
                $this->output->set_output('{"status": "update", "message": "'.sprintf(lang('update_panel_update_message'), $update->latestVersionName).'", "version": "'.$update->latestVersionName.'", "changelog_info": "'.sprintf(lang('update_panel_changelog_message'), $update->latestChangelog).'", "changelog": "'.$update->latestChangelog.'"}');
                return;
            } else {
                $this->output->set_content_type('application/json');
                $this->output->set_output('{"status": "uptodate", "message": "'.sprintf(lang('update_panel_uptodate'), software_name).'"}');
                return;
            }
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "'.addcslashes($update->getLastError(), '"').'"}');
            return;
        }

    }

    public function install_update()
    {
        if( $this->user_model->check_login() !== true && user_model::$group == 1 ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "Access denied!"}');
            return;
        }

        require_once APPPATH.'libraries'.DS.'update.php';

        $update = new AutoUpdate(true);
        $update->currentVersion = software_update_version;
        $update->updateUrl = update_url;
        $update->licensekey = $this->simplece_model->get_setting_val('license_key');

        $latest = $update->checkUpdate();
        if ($latest !== false) {

            if ($latest > $update->currentVersion) {
                if ($update->update()) {
                    $this->output->set_content_type('application/json');
                    $this->output->set_output('{"status": "success", "message": "'.sprintf(lang('update_panel_successful'), site_url('settings?active=system-info')).'"}');
                    return;
                }
                else {
                    $this->output->set_content_type('application/json');
                    $this->output->set_output('{"status": "error", "message": "'.lang('update_panel_failed').': '.addcslashes($update->getLastError(), '"').'"}');
                    return;
                }

            } else {
                $this->output->set_content_type('application/json');
                $this->output->set_output('{"status": "error", "message": "'.sprintf(lang('update_panel_uptodate'), software_name).'"}');
                return;
            }
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "'.addcslashes($update->getLastError(), '"').'"}');
            return;
        }
    }

    public function cke_upload()
    {
        if( $this->user_model->check_login() !== true ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "Access denied!"}');
            return;
        }

        /**
         * CKEditor Vars
         */
        $funcNum = $this->input->get('CKEditorFuncNum');
        $CKEditor = $this->input->get('CKEditor');
        $langCode = $this->input->get('langCode');

        /**
         * Upload Settings
         */
        $config['upload_path'] = FCPATH.uploads_dir.DS;
        $config['allowed_types'] = allowed_images;
        $config['max_size']	= 0;

        /* Load Upload Library */
        $this->load->library('upload', $config);

        $file = $_FILES['upload']['name'];

        /**
         * Do Upload
         */
        if ( !$this->upload->do_upload('upload'))
        {
            $error = $this->upload->display_errors();

            $this->output->set_output($error);
            return;
        }
        else
        {
            $data = $this->upload->data();
            $message = '';
            $url = base_url();
            $url = rtrim($url, '/');
            $url = $url.'/'.uploads_dir.'/'.$data['file_name'];
            $this->output->set_output('<script type=\'text/javascript\'>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', \''.$url.'\', \''.$message.'\');</script>');
            return;
        }
    }

    public function update_text_element($sce_id_url)
    {
        if( $this->user_model->check_login() !== true ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "Access denied!"}');
            return;
        }

        $this->load->model('text_model');

        $sce_id = $this->input->post('sce_id', true);
        $sce_loop = $this->input->post('sce_loop', true);
        $sce_row = $this->input->post('sce_row', true);
        $text = $this->input->post('text', true);
        $type = strtolower($this->input->post('type', true));

        if( is_numeric($sce_loop) && $sce_loop > 0 && is_numeric($sce_row) && $sce_row > 0 ) {
            loop_model::$loopID = $sce_loop;
            loop_model::$loopI = $sce_row;
        }

        if( $type == 'long' || $type == 'short' ) {
            $text = strip_tags($text, '<p><a>');
            $text = html_entity_decode($text);
        }

        if( $sce_id_url == $sce_id ) {
            $current_text = $this->text_model->get_text($sce_id, 'sce_id');

            if( is_numeric($current_text['id']) && !empty($current_text['id']) ) {
                $status = $this->text_model->update_text($current_text['id'], array(
                    'sce_id' => $sce_id,
                    'text' => $text,
                    'type' => $type,
                ));
            } else {
                $status = $this->text_model->create_text(array(
                    'sce_id' => $sce_id,
                    'text' => $text,
                    'type' => $type,
                ));
            }

            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "success", "message": "'.$status.'"}');
        }
    }

    public function add_row($loop_id, $row)
    {
        if( $this->user_model->check_login() !== true ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "Access denied!"}');
            return;
        }

        $this->load->model('loop_model');

        $loop_id_p = $this->input->post('loop_id', true);
        $row_p = $this->input->post('row', true);

        if( $loop_id == $loop_id_p && $row == $row_p ) {
            $add = $this->loop_model->add_row($loop_id, $row);

            if( $add == true ) {

                if( use_cache === true ) {
                    $this->cache->clean();
                }

                $this->output->set_content_type('application/json');
                $this->output->set_output('{"return": "true"}');
                return;
            }
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output('{"return": "false"}');
        return;
    }

    public function del_row($loop_id, $row)
    {
        if( $this->user_model->check_login() !== true ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "Access denied!"}');
            return;
        }

        $this->load->model('loop_model');

        $loop_id_p = $this->input->post('loop_id', true);
        $row_p = $this->input->post('row', true);

        if( $loop_id == $loop_id_p && $row == $row_p ) {
            $del = $this->loop_model->del_row($loop_id, $row);

            if( $del == true ) {

                if( use_cache === true ) {
                    $this->cache->clean();
                }

                $this->output->set_content_type('application/json');
                $this->output->set_output('{"return": "true"}');
                return;
            }
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output('{"return": "false"}');
        return;
    }

    public function move_row($loop_id)
    {
        if( $this->user_model->check_login() !== true ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"status": "error", "message": "Access denied!"}');
            return;
        }

        $this->load->model('loop_model');

        $loop_id_p = $this->input->post('loop_id', true);
        $json_data = $this->input->post('data', true);

        $json_data = json_decode($json_data);

        if( is_array($json_data) ){
            $json_data = $json_data[0];
        }

        if( use_cache === true ) {
            $this->cache->clean();
        }

        if( $loop_id == $loop_id_p ) {

            $loop_elements = array();

            foreach($json_data as $row_item) {
                $row_item = $this->loop_model->get_elements_for_row($row_item->row, $row_item->loop);
                $loop_elements[] = $row_item;
            }

            if( is_array($loop_elements) && count($loop_elements) >= 1 ) {
                $row = 1;
                foreach( $loop_elements as $elements ) {

                    $this->loop_model->set_new_row_for_elements($row, $elements);

                    $row++;
                }
            }
        }


        $this->output->set_content_type('application/json');
        $this->output->set_output('{"return": "true"}');
        return;
    }
}
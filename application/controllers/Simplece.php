<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 02/07/14
 * Time: 20:12
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class simplece extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if( ! defined('installation_date') ) {
            redirect( site_url('setup') );
            return;
        }

        $this->lang->load('sce', language);
        $this->load->helper('language');

        $this->load->database();
        $this->load->model('simplece_model');
        $this->load->model('user_model');
        $this->load->model('loop_model');

        if( $this->simplece_model->get_setting_val('disable_cache', 'no') == 'no' ) {
            $this->load->driver('cache', array('adapter' => 'file'));
            define('use_cache', true);
        } else {
            define('use_cache', false);
        }
    }

    /**
     * Demo-Mode
     */
    public function demo_mode()
    {
        $this->load->view('templates/header');
        $this->load->view('demo_mode');
        $this->load->view('templates/footer', array(
            'ckeditor' => false
        ));

        return;
    }

    /**
     * Login
     */
    public function login()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $captcha = $this->input->post('captcha', true);


        if( $this->user_model->check_login() === true ) {
            redirect(site_url('dashboard'));
            return;
        }

        $cap_status = false;
        if( get_setting('login_captcha', 'no') == 'yes' ) {
            $this->load->model('captcha_model');
            $cap_status = true;
        }

        if( !empty($username) && !empty($password) ) {
            if( $cap_status === true ) {
                $this->captcha_model->garbage_collection();

                if( $this->captcha_model->validate_captcha($captcha, $this->input->ip_address()) ) {
                    $login = $this->user_model->check_login_credentials($username, $password);
                }else {
                    $login_error = true;
                }
            } else {
                $login = $this->user_model->check_login_credentials($username, $password);
            }

            if( $login !== false && is_numeric($login) ) {
                $this->session->set_userdata(array(
                    'username' => $username,
                    'password' => md5($password.encryption_key)
                ));

                if( $this->simplece_model->get_setting_val('login_redirect') == 'frontend' ) {
                    redirect( get_upper_dir_link(site_url()) );
                    return;
                } else {
                    redirect(site_url('dashboard'));
                    return;
                }

            } else {
                $login_error = true;
            }
        } else {
            $login_error = false;
        }

        /**
         * Generate Captcha
         */
        if( $cap_status === true ) {
            $cap = $this->captcha_model->generate_captcha();
        } else {
            $cap = false;
        }
        // Captcha end

        $this->load->view('login', array(
            'login_error' => $login_error,
            'cap' => $cap
        ));
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect(site_url());
        return;
    }

    /**
     * Dashboard
     */
    public function dashboard()
    {

        if( $this->simplece_model->get_setting_val('disable_dashboard') == 'yes' ) {
            redirect( site_url('content') );
            return;
        }

        $this->load->view('templates/header', array(
            'body_class' => 'dashboard',
            'nav_active' => 'dashboard'
        ));
        $this->load->view('dashboard');
        $this->load->view('templates/footer');
    }

    /**
     * Content Overview
     */
    public function content()
    {

        $this->load->model('text_model');
        $this->load->model('image_model');
        $this->load->model('file_model');

        $this->load->helper('text');

        $messages = array();

        $active = trim($this->input->get('active', true));

        if( empty($active) ) {
            $active = false;
        }

        $del = $this->input->get('del', true);
        if( !empty($active) && !empty($del) && is_numeric($del) ) {
            if( $active == 'text' ) {
                $del = $this->text_model->delete($del);
            } elseif( $active == 'images' ) {
                $del = $this->image_model->delete($del);
            } elseif( $active == 'files' ) {
                $del = $this->file_model->delete($del);
            }

            if( $del == true ) {
                array_push($messages, lang('ct_del_success'));
                $messages['type'] = 'success';
            }
        }

        $text_q = trim($this->input->post('text-q', true));
        $image_q = trim($this->input->post('image-q', true));
        $file_q = trim($this->input->post('file-q', true));

        if( !empty($text_q) ) {
            $text = $this->text_model->search_content_list($text_q);
        } else {
            $text = $this->text_model->get_content_list();
        }

        if( !empty($image_q) ) {
            $images = $this->image_model->search_content_list($image_q);
        } else {
            $images = $this->image_model->get_content_list();
        }

        if( !empty($file_q) ) {
            $files = $this->file_model->search_content_list($file_q);
        } else {
            $files = $this->file_model->get_content_list();
        }

        $this->load->view('templates/header', array(
            'body_class' => 'content_overview',
            'nav_active' => 'content'
        ));

        $this->load->view('content_overview', array(
            'active' => $active,
            'text_q' => $text_q,
            'text' => $text,
            'image_q' => $image_q,
            'image' => $images,
            'file_q' => $file_q,
            'file' => $files,
            'messages' => $messages
        ));

        $this->load->view('templates/footer');
    }

    /**
     * Content Single
     *
     * @param bool|int $id
     */
    public function text($id=false)
    {
        $this->load->model('text_model');
        $this->load->helper('text');

        $messages = array();

        if( $id != false && is_numeric($id) ) {

            if( isset($_POST['save']) ) {
                $form_id = $this->input->post('id', true);
                $data = array(
                    'id' => $this->input->post('id', true),
                    'sce_id' => $this->input->post('sce_id', true),
                    'text' => $this->input->post('text', false),
                    'type' => $this->input->post('type', true)
                );

                /**
                 * ID Check
                 */
                if( $id == $form_id ) {

                    /* Validation */
                    $validate = $this->text_model->validate_text($data);

                    /* Check Validation Status */
                    if( $validate === true ) {
                        /* Update Text-Element */
                        if( $this->text_model->update_text($id, $data) ) {
                            array_push($messages, lang('ct_txt_success'));
                            $messages['type'] = 'success';
                        } else {
                            array_push($messages, lang('ct_txt_validation_unknown'));
                            $messages['type'] = 'error';
                        }
                    } else {
                        /* Push Validation Errors in Messages */
                        array_push($messages, $validate['message']);
                        $messages['type'] = 'error';
                    }
                }
            }

            $text = $this->text_model->get_text($id);

            if( $text == false || !is_array($text) ) {
                redirect( site_url('content') );
                return;
            }

            $this->load->view('templates/header', array(
                'body_class' => 'content_single',
                'nav_active' => 'content'
            ));

            $this->load->view('content_text_single', array(
                'text' => $text,
                'messages' => $messages
            ));

            $this->load->view('templates/footer', array(
                'ckeditor' => (($text['type']=='editor')?true:false),
                'aceeditor' => (($text['type']=='html')?true:false),
                'editor_mode' => (($text['type']=='html')?'html':false)
            ));
        }
    }

    /**
     * Image Single
     *
     * @param bool|int $id
     */
    public function image($id=false)
    {
        $this->load->model('image_model');

        $messages = array();

        if( isset($_POST['save']) ) {
            $form_id = $this->input->post('id', true);
            $data = array(
                'id' => $this->input->post('id', true),
                'sce_id' => $this->input->post('sce_id', true),
                'alt' => $this->input->post('alt', true),
                'link' => $this->input->post('link', true),
                'lightbox' => (($this->input->post('lightbox', true)==1)?1:0)
            );

            /**
             * ID Check
             */
            if( $id == $form_id ) {

                /* Validation */
                $validate = $this->image_model->validate_image($data);

                /* Check Validation Status */
                if( $validate === true ) {

                    $upload = $this->image_model->do_upload();

                    if( $upload['status'] == true ) {


                        if( $upload['file']['file_name'] ) {
                            $data['path'] = $upload['file']['file_name'];
                        } else {
                            $data['path'] = false;
                        }

                        /* Update Image-Element */
                        if( $this->image_model->update_image($id, $data) ) {
                            array_push($messages, lang('ct_img_success'));
                            $messages['type'] = 'success';
                        } else {
                            array_push($messages, lang('ct_img_validation_unknown'));
                            $messages['type'] = 'error';
                        }
                    } else {
                        array_push($messages, $upload['message']);
                        $messages['type'] = 'error';
                    }

                } else {
                    /* Push Validation Errors in Messages */
                    array_push($messages, $validate['message']);
                    $messages['type'] = 'error';
                }
            }
        }

        $image = $this->image_model->get_image($id);

        if( !isset($_POST['save']) && $this->input->get('delete', true) == 'true' ) {
            @unlink(upload_path($image['path']));

            $data = array(
                'id' => $image['id'],
                'sce_id' => $image['sce_id'],
                'path' => '',
                'alt' => $image['alt'],
                'link' => $image['link'],
                'lightbox' => (($image['lightbox']==1)?1:0)
            );

            if( $this->image_model->update_image($id, $data) ) {
                $image['path'] = '';
            }
        }

        $this->load->view('templates/header', array(
            'body_class' => 'content_single',
            'nav_active' => 'content'
        ));

        $this->load->view('content_image_single', array(
            'image' => $image,
            'messages' => $messages
        ));

        $this->load->view('templates/footer', array(
            'ckeditor' => false
        ));
    }

    /**
     * File Single
     *
     * @param bool|int $id
     */
    public function file($id=false)
    {
        $this->load->model('file_model');

        $this->load->helper('file');

        $messages = array();

        if( isset($_POST['save']) ) {
            $form_id = $this->input->post('id', true);
            $data = array(
                'id' => $this->input->post('id', true),
                'sce_id' => $this->input->post('sce_id', true),
                'text' => $this->input->post('text', true),
            );

            /**
             * ID Check
             */
            if( $id == $form_id ) {

                /* Validation */
                $validate = $this->file_model->validate_file($data);

                /* Check Validation Status */
                if( $validate === true ) {

                    $upload = $this->file_model->do_upload();

                    if( $upload['status'] == true ) {


                        if( $upload['file']['file_name'] ) {
                            $data['path'] = $upload['file']['file_name'];
                        } else {
                            $data['path'] = false;
                        }

                        /* Update Image-Element */
                        if( $this->file_model->update_file($id, $data) ) {
                            array_push($messages, lang('ct_file_success'));
                            $messages['type'] = 'success';
                        } else {
                            array_push($messages, lang('ct_file_validation_unknown'));
                            $messages['type'] = 'error';
                        }
                    } else {
                        array_push($messages, $upload['message']);
                        $messages['type'] = 'error';
                    }

                } else {
                    /* Push Validation Errors in Messages */
                    array_push($messages, $validate['message']);
                    $messages['type'] = 'error';
                }
            }
        }

        $file = $this->file_model->get_file($id);

        if( !isset($_POST['save']) && $this->input->get('delete', true) == 'true' ) {
            @unlink(upload_path($file['path']));

            $data = array(
                'id' => $file['id'],
                'sce_id' => $file['sce_id'],
                'text' => $file['text'],
                'path' => ''
            );

            if( $this->file_model->update_file($id, $data) ) {
                $file['path'] = '';
            }
        }

        $this->load->view('templates/header', array(
            'body_class' => 'content_single',
            'nav_active' => 'content'
        ));

        $this->load->view('content_file_single', array(
            'file' => $file,
            'messages' => $messages
        ));

        $this->load->view('templates/footer', array(
            'ckeditor' => false
        ));
    }

    /**
     * Files Overview
     */
    public function files_overview()
    {

        if( !$this->user_model->can_user_access('files') ) {
            show_404();
            return;
        }

        if( demo_mode === true ) {
            return $this->demo_mode();
        }

        $this->load->helper('file');

        $messages = array();

        $open_dir = $this->input->get('open-dir', true);
        $del = $this->input->get('del', true);
        $del_dir = $this->input->get('del_dir', true);
        $uploads_dir = FCPATH.uploads_dir.DS;

        $name = trim($this->input->post('name', true));
        $folder = trim($this->input->post('folder', true));
        $file = trim($this->input->post('file', true));


        if( $open_dir && !empty($open_dir) ) {
            $dir = $open_dir;
        } else {
            $dir = rtrim(FCPATH, DS);
            $dirs = explode(DS, $dir);
            $sce_folder = $dirs[(count($dirs)-1)];

            $pos = strrpos($dir, $sce_folder);

            if($pos !== false)
            {
                $dir = substr_replace($dir, '', $pos, strlen($sce_folder));
            }
        }

        if( !empty($name) ) {
            if( $folder == 'folder' ) {
                @mkdir($dir.DS.$name);
            }

            if( $file == 'file' ) {
                @write_file($dir.DS.$name, '');
            }
        }

        if( isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name']) ) {
            $upload = $this->simplece_model->upload('upload', '*', $dir);

            if( !$upload ) {
                array_push($messages, 'Upload failed!');
                $messages['type'] = 'error';
            }
        }

        if( $del && !empty($del) ) {
            @unlink(rtrim($open_dir, DS).DS.$del);
        }

        if( $del_dir && !empty($del_dir) ) {

            $dir_full_path = rtrim($open_dir, DS).DS.$del_dir;

            if( @is_dir($dir_full_path) ) {
                @$this->simplece_model->remove_dir($dir_full_path);
            }
        }


        $uploads = get_dir_file_info($uploads_dir, true);
        $webspace_files = get_dir_file_info($dir, true);

        $this->load->view('templates/header', array(
            'body_class' => 'files',
            'nav_active' => 'files'
        ));

        $this->load->view('files_overview', array(
            'messages' => $messages,
            'uploads' => $uploads,
            'uploads_dir' => $uploads_dir,
            'dir' => $dir,
            'webspace_files' => $webspace_files
        ));

        $this->load->view('templates/footer', array(
            'ckeditor' => false
        ));
    }

    /**
     * Edit a File
     */
    public function edit_file()
    {
        if( !$this->user_model->can_user_access('files') ) {
            show_404();
            return;
        }

        $messages = array();

        $this->load->helper('file');
        $file = $this->input->get('file', true);
        $post_file_content = $this->input->post('file_content', false);


        $file_extension = explode('.', $file);
        $file_extension = strtolower($file_extension[(count($file_extension)-1)]);

        if( file_exists($file) && is_really_writable($file) && in_array($file_extension, explode('|', editable_files)) ) {


            if( !empty($post_file_content) ) {
                if( write_file($file, $post_file_content) ) {
                    array_push($messages, lang('files_updated'));
                    $messages['type'] = 'success';
                } else {
                    array_push($messages, lang('files_not_updated'));
                    $messages['type'] = 'error';
                }
            }


            $file_status = true;
            $file_content = read_file($file);

            $folder_path = dirname($file);

            switch($file_extension) {
                case 'php':
                case 'php4':
                case 'php5':
                    $editor_mode = 'php';
                    break;
                case 'css':
                    $editor_mode = 'css';
                    break;
                case 'js':
                    $editor_mode = 'js';
                    break;
                case 'html':
                    $editor_mode = 'html';
                    break;
                case 'xml':
                    $editor_mode = 'xml';
                    break;
                case 'json':
                    $editor_mode = 'json';
                    break;
                case 'txt':
                    $editor_mode = 'text';
                    break;
                default:
                    $editor_mode = 'text';
                    break;
            }

        } else {
            $file_status = false;
            $file_content = false;
            $editor_mode = false;
            $folder_path = false;
        }

        $this->load->view('templates/header', array(
            'body_class' => 'files_single',
            'nav_active' => 'files'
        ));

        $this->load->view('files_edit', array(
            'messages' => $messages,
            'folder_path' => $folder_path,
            'file' => $file,
            'file_status' => $file_status,
            'file_content' => $file_content
        ));

        $this->load->view('templates/footer', array(
            'ckeditor' => false,
            'aceeditor' => true,
            'editor_mode' => $editor_mode
        ));
    }

    /**
     * User Overview
     */
    public function user()
    {
        if( !$this->user_model->can_user_access('user') ) {
            show_404();
            return;
        }

        $this->load->model('user_model');

        $messages = array();

        $this->load->view('templates/header', array(
            'body_class' => 'user',
            'nav_active' => 'user'
        ));

        $this->load->view('user', array(
            'messages' => $messages,
            'users' => $this->user_model->get_all_users()
        ));

        $this->load->view('templates/footer', array(
            'ckeditor' => false,
            'aceeditor' => false
        ));
    }

    /**
     * Edit a User-Profile
     *
     * @param int|bool $user_id
     */
    public function edit_user($user_id=false)
    {
        if( !$this->user_model->can_user_access('user') && $user_id != user_model::$user_id ) {
            show_404();
            return;
        }

        $this->load->model('user_model');

        $messages = array();

        if( isset($_POST['save']) && is_numeric($user_id) && $user_id > 0 ) {
            $data = array(
                'id' => $user_id,
                'username' => $this->input->post('username', true),
                'email' => $this->input->post('email', true),
                'firstname' => $this->input->post('firstname', true),
                'surname' => $this->input->post('surname', true),
                'password' => $this->input->post('password', true),
                'password2' => $this->input->post('password2', true),
                'group' => $this->input->post('group', true)
            );

            $validate = $this->user_model->validate_user($data);

            if( $validate === true ) {
                $update = $this->user_model->update_user($user_id, $data);

                if( $update ) {

                    /**
                     * Update Session Password on change
                     */
                    $password_input = $this->input->post('password', true);
                    $password_session = $this->session->userdata('password');
                    if( md5($password_input.encryption_key) != $password_session ) {
                        user_model::$password = $password_input;
                        $this->session->set_userdata('password', md5($password_input.encryption_key));
                    }

                    array_push($messages, lang('user_success_msg'));
                    $messages['type'] = 'success';
                } else {
                    array_push($messages, lang('user_error_msg'));
                    $messages['type'] = 'error';
                }
            } else {
                array_push($messages, $validate['message']);
                $messages['type'] = 'error';
            }
        } elseif ( isset($_POST['save']) && $user_id == 'new' ) {
            $data = array(
                'id' => false,
                'username' => $this->input->post('username', true),
                'email' => $this->input->post('email', true),
                'firstname' => $this->input->post('firstname', true),
                'surname' => $this->input->post('surname', true),
                'password' => $this->input->post('password', true),
                'password2' => $this->input->post('password2', true),
                'group' => $this->input->post('group', true)
            );

            $validate = $this->user_model->validate_user($data, true);

            if( $validate === true ) {
                $insert = $this->user_model->insert_user($data);

                if( $insert !== false && is_numeric($insert) ) {
                    redirect( site_url('user/'.$insert.'?new_user=true') );
                    return;
                } else {
                    array_push($messages, lang('user_create_error_msg'));
                    $messages['type'] = 'error';
                }
            } else {
                array_push($messages, $validate['message']);
                $messages['type'] = 'error';
            }
        }

        if( $this->input->get('new_user', true) == 'true' ) {
            array_push($messages, lang('user_create_success_msg'));
            $messages['type'] = 'success';
        }

        if( is_numeric($user_id) && $user_id > 0 ) {
            $user = $this->user_model->get_user($user_id);
        } else {
            $user = false;
        }

        $this->load->view('templates/header', array(
            'body_class' => 'user_edit',
            'nav_active' => 'user'
        ));

        $this->load->view('user_edit', array(
            'messages' => $messages,
            'user' => $user
        ));

        $this->load->view('templates/footer', array(
            'ckeditor' => false,
            'aceeditor' => false
        ));
    }

    /**
     * Delete a User
     *
     * @param int $user_id
     */
    public function del_user($user_id)
    {
        if( !$this->user_model->can_user_access('user') ) {
            show_404();
            return;
        }

        $this->load->model('user_model');

        if( $user_id != user_model::$user_id ) {
            $this->user_model->delete_user($user_id);
        }

        redirect(site_url('user'));
        return;
    }

    /**
     * Settings
     */
    public function settings()
    {
        if( !$this->user_model->can_user_access('settings') ) {
            show_404();
            return;
        }

        $messages = array();
        $active = trim($this->input->get('active', true));
        $active2 = trim($this->input->post('active', true));

        if( !empty($active2) ) {
            $active = $active2;
        }

        if( isset($_POST['save']) ) {

            $license_key = $this->input->post('license_key', true);
            $validate_license = $this->simplece_model->validate_license($license_key);

            if( $validate_license === false ) {
                array_push($messages, lang('settings_license_server_unavailable'));
                $messages['type'] = 'error';
            } else {

                if( $validate_license['status'] == 'valid' ) {
                    $this->simplece_model->save_settings();

                    array_push($messages, lang('settings_msg_success'));
                    $messages['type'] = 'success';
                } else {

                    $this->simplece_model->update_setting('license_key', '');

                    array_push($messages, $validate_license['message']);
                    $messages['type'] = 'error';
                }

            }


        }

        $this->load->view('templates/header', array(
            'body_class' => 'settings',
            'nav_active' => 'settings',
            'farbtastic' => true
        ));

        $this->load->view('settings', array(
            'active' => $active,
            'messages' => $messages
        ));

        $this->load->view('templates/footer', array(
            'ckeditor' => false,
            'aceeditor' => false,
            'farbtastic' => true
        ));
    }

    /**
     * Developer
     */
    public function developer()
    {

        if( !$this->user_model->can_user_access('developer') ) {
            show_404();
            return;
        }

        $active = trim($this->input->get('active', true));

        $this->load->view('templates/header', array(
            'active' => $active,
            'body_class' => 'developer',
            'nav_active' => 'developer'
        ));

        if( language == 'german' ) {
            $this->load->view('developer_de');
        } else {
            $this->load->view('developer');
        }

        $this->load->view('templates/footer');
    }

    /**
     * Backup
     */
    public function backup()
    {

        if( !$this->user_model->can_user_access('backup') ) {
            show_404();
            return;
        }

        if( demo_mode === true ) {
            return $this->demo_mode();
        }

        $messages = array();

        $this->load->helper('file');
        $this->load->dbutil();
        $this->load->library('zip');

        $backup_path = FCPATH.backups_dir.DS;
        $image_cache = upload_path(thumb_cache_dir);
        $text_cache = APPPATH.cache_directory;
        $update_cache = UPDATE_DIR_TEMP;

        $tables = array(db_prefix.text_table, db_prefix.image_table, db_prefix.file_table, db_prefix.user_table, db_prefix.settings_table);

        if ( $this->input->get('action', true) == 'do_backup' ) {

            /**
             * Database Backup
             */
            $date = date('Y-m-d__h_i_s');
            $file_name = 'backup_'.$date.'_db.zip';
            $file_name2 = 'backup_'.$date.'_uploads.zip';

            $backup =& $this->dbutil->backup(array(
                'tables' => $tables,
                'format' => 'zip',
                'filename' => $file_name
            ));

            $write = write_file($backup_path.$file_name, $backup);

            /**
             * Uploads Backup
             */
            $this->zip->clear_data();

            $this->zip->read_dir(upload_path(), false);
            $write2 = $this->zip->archive($backup_path.$file_name2);

            if( $backup && $write && $write2 ) {
                array_push($messages, lang('backup_msg_success'));
                $messages['type'] = 'success';
            } else {
                array_push($messages, lang('backup_msg_error'));
                $messages['type'] = 'error';
            }

        } else if ( $this->input->get('action', true) == 'do_optimization' ) {

            $error = false;

            // delete empty text elements
            $this->db->where('text', '');
            $this->db->delete(text_table);

            // delete empty image elements
            $this->db->where('path', '');
            $this->db->delete(image_table);

            // delete empty file elements
            $this->db->where('path', '');
            $this->db->delete(file_table);

            foreach ( $tables as $table ) {
                $repair = $this->dbutil->repair_table($table);
                $optimize = $this->dbutil->optimize_table($table);

                if( !$repair || !$optimize ) {
                    $error = true;
                }
            }

            if( $error === false ) {
                array_push($messages, lang('backup_msg_opt_success'));
                $messages['type'] = 'success';
            } else {
                array_push($messages, lang('backup_msg_opt_error'));
                $messages['type'] = 'error';
            }

        }  else if ( $this->input->get('action', true) == 'download' ) {
            $file = $this->input->get('file', true);

            if ( !empty($file) && file_exists($backup_path.$file) ) {

                $this->load->helper('download');

                $file_content = read_file($backup_path.$file);
                force_download($file, $file_content);
            }
        } else if ( $this->input->get('action', true) == 'clean_caches' ) {
            $caches = array($image_cache, $text_cache, $update_cache);

            foreach( $caches as $cache_dir ) {

                $cache_content = get_dir_file_info($cache_dir);

                if( ! $cache_content )
                    continue;

                foreach( $cache_content as $cache_file ) {
                    if( @!is_dir($cache_file['server_path']) ) {
                        @unlink($cache_file['server_path']);
                    }
                }
            }

            array_push($messages, lang('cache_success_msg'));
            $messages['type'] = 'success';
        } else if ( $this->input->get('del', true) != '' ) {
            $del = $this->input->get('del', true);

            if( strstr($del, DS) === false ) {
                @unlink($backup_path.$del);
            }
        }

        $backup_files = get_dir_file_info($backup_path);
        $image_cache_info = get_dir_file_info($image_cache);
        $text_cache_info = get_dir_file_info($text_cache);
        $update_cache_info = get_dir_file_info($update_cache);

        $this->load->view('templates/header', array(
            'body_class' => 'backup',
            'nav_active' => 'backup'
        ));
        $this->load->view('backup', array(
            'messages' => $messages,
            'backup_path' => $backup_path,
            'backup_files' => $backup_files,

            'image_cache' => $image_cache,
            'text_cache' => $text_cache,
            'update_cache' => $update_cache,

            'image_cache_info' => $image_cache_info,
            'text_cache_info' => $text_cache_info,
            'update_cache_info' => $update_cache_info
        ));
        $this->load->view('templates/footer');
    }

    public function reset_demo_data()
    {
        $key = $this->input->get('key', true);

        if( demo_mode !== true || $key != encryption_key ) {
            show_404();
            return;
        }

        $this->simplece_model->reset_demo_data();
        return;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 17/07/14
 * Time: 21:25
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class simplece_model extends CI_Model
{
    public function __construct()
    {

    }

    /**
     * Update all Settings
     */
    public function save_settings()
    {
        $settings_keys = array('code_style', 'editor_mode', 'disable_dashboard', 'disable_login_animation', 'disable_lightbox', 'disable_cache', 'login_captcha', 'login_redirect', 'license_key', 'user_files_menu', 'user_developer_menu', 'user_backup_menu', 'user_user_menu', 'user_settings_menu', 'fe_color_1', 'fe_color_2', 'software_name', 'copyright');

        $settings_with_upload = array('login_logo', 'topbar_logo', 'login_background', 'backend_background');

        foreach ( $settings_keys as $setting ) {

            if( !isset($_POST[$setting]) )
                continue;

            if( demo_mode === true && $setting == 'license_key' )
                continue;

            $post_value = $this->input->post($setting);
            $this->update_setting($setting, $post_value);
        }

        foreach ( $settings_with_upload as $setting ) {

            $delete = $this->input->post('delete_'.$setting);

            if( $delete == 'delete' ) {
                $old_setting = get_setting($setting);
                @unlink(FCPATH.uploads_dir.DS.$old_setting);

                $this->delete_setting($setting);
            }

            if( isset($_FILES[$setting]['name']) && !empty($_FILES[$setting]['name']) ) {
                $upload = $this->upload($setting, allowed_images);

                if( $upload['status'] == true ) {

                    $old_setting = get_setting($setting);

                    if( $old_setting ) {
                        $this->load->helper('file');
                        @unlink(FCPATH.uploads_dir.DS.$old_setting);
                    }

                    $this->update_setting($setting, $upload['file']['file_name']);
                } else {
                    /* @todo Check $uploads content */
                    //return $upload;
                }
            }
        }
    }

    /**
     * Get a Setting
     *
     * @param string $key
     * @param string|bool $default
     * @return bool|array
     */
    public function get_setting($key, $default=false)
    {
        $this->db->select('*');
        $this->db->from(settings_table);
        $this->db->where('key', $key);
        $get = $this->db->get();

        if( $get->num_rows() == 1 ) {
            $result = $get->result_array();

            return $result[0];
        } else if( $default !== false ) {
            return $default;
        }

        return false;
    }

    /**
     * Get only the Setting value
     *
     * @param string $key
     * @param string|bool $default
     * @return string|bool
     */
    public function get_setting_val($key, $default=false)
    {
        $setting = $this->get_setting($key, $default);

        if( is_array($setting) ) {
            return $setting['value'];
        } else {
            return $setting;
        }
    }

    /**
     * Add a new Setting
     *
     * @param string $key
     * @param string $value
     * @return bool|int
     */
    public function add_setting($key, $value)
    {
        $insert = $this->db->insert(settings_table, array(
            'key' => $key,
            'value' => $value
        ));

        if( $insert ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Delete a Setting
     *
     * @param string $key
     * @return bool
     */
    public function delete_setting($key)
    {
        $delete = $this->db->delete(settings_table, array(
            'key' => $key
        ));

        return $delete;
    }

    /**
     * Update a Setting or create it, if not exist
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function update_setting($key, $value)
    {
        $setting = $this->get_setting($key);

        if( $setting !== false && is_array($setting) ) {
            $this->db->where('id', $setting['id']);
            $update = $this->db->update(settings_table, array(
                'value' => $value
            ));

            return $update;
        } else {
            $insert = $this->add_setting($key, $value);

            if( $insert && is_numeric($insert) ) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Upload function
     *
     * @param string $post_key
     * @param string|bool $allowed_types
     * @param string|bool $upload_path
     * @return array
     */
    public function upload($post_key, $allowed_types=false, $upload_path=false)
    {
        if( !isset($_FILES[$post_key]['name']) || empty($_FILES[$post_key]['name']) ) {
            return array(
                'status' => true,
                'file' => false
            );
        }

        /**
         * Upload Settings
         */
        if( $upload_path === false ) {
            $config['upload_path'] = FCPATH.uploads_dir.DS;
        } else {
            $config['upload_path'] = $upload_path;
        }

        if( $allowed_types === false ) {
            $config['allowed_types'] = '*';
        } else {
            $config['allowed_types'] = $allowed_types;
        }

        $config['max_size']	= 0;

        /* Load Upload Library */
        $this->load->library('upload', $config);

        /**
         * Do Upload
         */
        if ( !$this->upload->do_upload($post_key))
        {
            $error = $this->upload->display_errors();

            return array(
                'status' => false,
                'message' => strip_tags($error)
            );
        }
        else
        {
            $data = $this->upload->data();

            return array(
                'status' => true,
                'file' => $data
            );
        }
    }

    public function validate_license($license_key)
    {
        $license_check = @$this->file_get_contents_curl(update_url.'/license-check?license-key='.urlencode($license_key).'&domain='.urlencode(site_url()));

        if( $license_check == false )
            return false;

        $license_content = json_decode($license_check, true);

        if( demo_mode === true ) {
            $license_content['status'] = 'valid';
            $license_content['message'] = 'Your License Key is valid!';
        }

        return $license_content;
    }

    public function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function remove_dir($dir) {
        if (@is_dir($dir)) {

            $objects = scandir($dir);

            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir.DS.$object) == "dir")
                        $this->remove_dir($dir.DS.$object);
                    else
                        @unlink($dir.DS.$object);
                }
            }

            reset($objects);

            @rmdir($dir);
        }
    }

    public function reset_demo_data()
    {
        if( demo_mode !== true ) {
            return;
        }

        $license_key = license_key;

        $firstname = 'John';
        $surname = 'Doe';
        $username = demo_user;
        $password = demo_pw;
        $email = 'mail@example.com';

        $error = false;

        /**
         * Clean current tables
         */
        $this->db->truncate(text_table);
        $this->db->truncate(image_table);
        $this->db->truncate(file_table);
        $this->db->truncate(loop_table);
        $this->db->truncate(user_table);
        $this->db->truncate(settings_table);

        $user_data = array(
            'username' => $username,
            'password' => md5($password.encryption_key),
            'email' => $email,
            'firstname' => $firstname,
            'surname' => $surname,
            'group' => 1
        );

        if( ! $this->db->insert(user_table, $user_data) ) {
            $error = true;
        }

        $standard_settings = array(
            'code_style' => array(
                'key' => 'code_style',
                'value' => 'html5'
            ),
            'editor_mode' => array(
                'key' => 'editor_mode',
                'value' => 'Standard'
            ),
            'disable_dashboard' => array(
                'key' => 'disable_dashboard',
                'value' => 'no'
            ),
            'disable_login_animation' => array(
                'key' => 'disable_login_animation',
                'value' => 'no'
            ),
            'disable_lightbox' => array(
                'key' => 'disable_lightbox',
                'value' => 'no'
            ),
            'disable_cache' => array(
                'key' => 'disable_cache',
                'value' => 'yes'
            ),
            'login_redirect' => array(
                'key' => 'login_redirect',
                'value' => 'backend'
            ),
            'license_key' => array(
                'key' => 'license_key',
                'value' => $license_key
            ),

            'user_files_menu' => array(
                'key' => 'user_files_menu',
                'value' => 'no'
            ),
            'user_developer_menu' => array(
                'key' => 'user_developer_menu',
                'value' => 'no'
            ),
            'user_backup_menu' => array(
                'key' => 'user_backup_menu',
                'value' => 'no'
            ),
            'user_user_menu' => array(
                'key' => 'user_user_menu',
                'value' => 'no'
            ),
            'user_settings_menu' => array(
                'key' => 'user_settings_menu',
                'value' => 'no'
            ),

            'fe_color_1' => array(
                'key' => 'fe_color_1',
                'value' => fe_color_1
            ),
            'fe_color_2' => array(
                'key' => 'fe_color_2',
                'value' => fe_color_2
            )
        );

        foreach ( $standard_settings as $setting ) {
            $setting_data = array(
                'key' => $setting['key'],
                'value' => $setting['value']
            );

            if( ! $this->db->insert(settings_table, $setting_data) ) {
                $error = true;
            }
        }

        /**
         * Text Data
         */
        $demo_assets = array(
            10 => array(
                'sce_id' => 10,
                'text' => 'Ullamcorper Parturient Tortor',
                'type' => 'short'
            ),
            15 => array(
                'sce_id' => 15,
                'text' => '<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Nulla vitae elit libero, a pharetra augue. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>',
                'type' => 'editor'
            ),
            20 => array(
                'sce_id' => 20,
                'text' => 'Nibh Etiam Purus',
                'type' => 'short'
            ),
            25 => array(
                'sce_id' => 25,
                'text' => '<p><strong>Praesent commodo</strong><br>cursus magna, vel scelerisque nisl consectetur et. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>',
                'type' => 'editor'
            ),
            30 => array(
                'sce_id' => 30,
                'text' => '<p><strong>Praesent commodo</strong><br>cursus magna, vel scelerisque nisl consectetur et. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>',
                'type' => 'editor'
            ),
            35 => array(
                'sce_id' => 35,
                'text' => '<p><strong>Praesent commodo</strong><br>cursus magna, vel scelerisque nisl consectetur et. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>',
                'type' => 'editor'
            ),
            40 => array(
                'sce_id' => 40,
                'text' => '<p><strong>Praesent commodo</strong><br>cursus magna, vel scelerisque nisl consectetur et. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>',
                'type' => 'editor'
            ),
            41 => array(
                'sce_id' => 41,
                'text' => '<ul class="check-list">
<li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr scing</li>
<li>Dolor sit amet, consetetur sadipscing elitr scing elitr scing elitr</li>
<li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</li>
<li>Dolor sit amet, consetetur sadipscing elitr scing elitr scing elitr</li>
<li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</li>
<li>Dolor sit amet, consetetur sadipscing elitrscing elitr scing elitr</li>
</ul>',
                'type' => 'html'
            ),
            42 => array(
                'sce_id' => 42,
                'text' => '<ul class="check-list">
<li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr scing</li>
<li>Dolor sit amet, consetetur sadipscing elitr scing elitr scing elitr</li>
<li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</li>
<li>Dolor sit amet, consetetur sadipscing elitr scing elitr scing elitr</li>
<li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</li>
<li>Dolor sit amet, consetetur sadipscing elitrscing elitr scing elitr</li>
</ul>',
                'type' => 'html'
            ),
            45 => array(
                'sce_id' => 45,
                'text' => '<h2>Amet Vehicula Ullamcorper Magna</h2><p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec sed odio dui. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>',
                'type' => 'editor'
            ),
            50 => array(
                'sce_id' => 50,
                'text' => 'Nullam Fringilla Elit',
                'type' => 'short'
            ),
            60 => array(
                'sce_id' => 60,
                'text' => 'Nullam Fringilla Elit',
                'type' => 'short'
            ),
            70 => array(
                'sce_id' => 70,
                'text' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod.

Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Maecenas sed diam eget risus varius blandit sit amet non magna. Donec id elit non mi porta gravida at eget metus. Curabitur blandit tempus porttitor.

Sed posuere consectetur est at lobortis. Nullam id dolor id nibh ultricies vehicula ut id elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Donec sed odio dui. Maecenas sed diam eget risus varius blandit sit amet non magna.',
                'type' => 'long'
            ),
            80 => array(
                'sce_id' => 80,
                'text' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod.

Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Maecenas sed diam eget risus varius blandit sit amet non magna. Donec id elit non mi porta gravida at eget metus. Curabitur blandit tempus porttitor.

Sed posuere consectetur est at lobortis. Nullam id dolor id nibh ultricies vehicula ut id elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Donec sed odio dui. Maecenas sed diam eget risus varius blandit sit amet non magna.',
                'type' => 'long'
            ),
            90 => array(
                'sce_id' => 90,
                'text' => 'legal notice',
                'type' => 'short'
            ),
            100 => array(
                'sce_id' => 100,
                'text' => 'Nullam Nibh Commodo'."\n".'Pharetra Egestas'."\n".'Inceptos Sit Vulputate',
                'type' => 'long'
            ),
            110 => array(
                'sce_id' => 110,
                'text' => 'Nullam Nibh Commodo'."\n".'Pharetra Egestas'."\n".'Inceptos Sit Vulputate',
                'type' => 'long'
            ),
            120 => array(
                'sce_id' => 120,
                'text' => 'Nullam Nibh Commodo'."\n".'Pharetra Egestas'."\n".'Inceptos Sit Vulputate',
                'type' => 'long'
            )
        );

        foreach ( $demo_assets as $data ) {
            $data = array(
                'sce_id' => $data['sce_id'],
                'text' => $data['text'],
                'type' => $data['type'],
                'modified' => date('Y-m-d H:i:s'),
                'created' => date('Y-m-d H:i:s')
            );

            if( ! $this->db->insert(text_table, $data) ) {
                $error = true;
            }
        }

        $demo_assets2 = array(
            0 => array(
                'sce_id' => 10,
                'path' => 'test-image.gif',
                'alt' => 'Test Image',
                'link' => '',
                'lightbox' => 1,
                'loop_id' => 10,
                'loop_row' => 1
            ),
            1 => array(
                'sce_id' => 10,
                'path' => 'test-image2.gif',
                'alt' => 'Test Image',
                'link' => '',
                'lightbox' => 1,
                'loop_id' => 10,
                'loop_row' => 2
            ),
            2 => array(
                'sce_id' => 10,
                'path' => 'test-image.gif',
                'alt' => 'Test Image',
                'link' => '',
                'lightbox' => 1,
                'loop_id' => 10,
                'loop_row' => 3
            ),
            3 => array(
                'sce_id' => 10,
                'path' => 'test-image2.gif',
                'alt' => 'Test Image',
                'link' => '',
                'lightbox' => 1,
                'loop_id' => 10,
                'loop_row' => 4
            )
        );

        foreach ( $demo_assets2 as $data ) {
            $data = array(
                'sce_id' => $data['sce_id'],
                'path' => $data['path'],
                'alt' => $data['alt'],
                'link' => $data['link'],
                'lightbox' => $data['lightbox'],
                'loop_id' => $data['loop_id'],
                'loop_row' => $data['loop_row']
            );

            if( ! $this->db->insert(image_table, $data) ) {
                $error = true;
            }
        }

        /**
         * Loop Data
         */
        $data = array(
            'loop_id' => 10,
            'rows' => 4
        );

        if( ! $this->db->insert(loop_table, $data) ) {
            $error = true;
        }

        /**
         * DB optim
         */
        $this->load->dbutil();
        $tables = array(db_prefix.text_table, db_prefix.image_table, db_prefix.file_table, db_prefix.user_table, db_prefix.settings_table);

        foreach ( $tables as $table ) {
            $repair = $this->dbutil->repair_table($table);
            $optimize = $this->dbutil->optimize_table($table);

            if( !$repair || !$optimize ) {
                $error = true;
            }
        }

        /**
         * Delete files
         */
        $this->load->helper('file');
        $delete_dirs = array(FCPATH.DS.uploads_dir, FCPATH.DS.uploads_dir.DS.thumb_cache_dir);

        foreach ( $delete_dirs as $dir ) {
            $content = get_dir_file_info($dir);

            if( ! $content )
                continue;

            foreach( $content as $file ) {
                if( @!is_dir($file['server_path']) ) {
                    @unlink($file['server_path']);
                }
            }
        }

        if( file_exists( FCPATH.DS.'demo-data'.DS.'test-image.gif' ) ) {
            $img_content = read_file(FCPATH.DS.'demo-data'.DS.'test-image.gif');
            write_file(FCPATH.DS.uploads_dir.DS.'test-image.gif', $img_content);
        }

        if( file_exists( FCPATH.DS.'demo-data'.DS.'test-image2.gif' ) ) {
            $img_content = read_file(FCPATH.DS.'demo-data'.DS.'test-image2.gif');
            write_file(FCPATH.DS.uploads_dir.DS.'test-image2.gif', $img_content);
        }

        if( $error === false ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "true"}');
            return;
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "Unable to install standard settings data set!"}');
            return;
        }
    }
}
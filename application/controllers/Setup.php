<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 17.08.14
 * Time: 21:16
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class setup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $lang = trim($this->input->get('language', true));

        if( empty($lang) || ($lang != 'english' && $lang != 'german') ) {
            $lang = 'english';
        }

        define('setup_lang', $lang);

        $this->lang->load('sce', $lang);
        $this->load->helper('language');
        $this->load->model('simplece_model');
    }

    public function welcome()
    {
        if( defined('installation_date') ) {
            redirect(site_url());
            return;
        }

        $this->load->helper('file');

        $dirs_to_check = array(
            'config.php',
            FCPATH.'uploads',
            FCPATH.'backups',
            APPPATH.'cache',
            APPPATH.'logs',
            APPPATH.'tmp'
        );

        $this->load->view('setup', array(
            'dirs_to_check' => $dirs_to_check
        ));
    }

    public function setup_data_check()
    {
        if( defined('installation_date') ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "Config file already exist!"}');
            return;
        }

        $db_driver = trim($this->input->get('driver'));
        $db_server = trim($this->input->get('db_server'));
        $db_username = trim($this->input->get('db_username'));
        $db_password = trim($this->input->get('db_password'));
        $db_prefix = trim($this->input->get('db_prefix'));
        $database = trim($this->input->get('database'));

        if( $db_driver == 'mysqli' ) {
            $connect = @mysqli_connect($db_server, $db_username, $db_password);
            $select_db = @mysqli_select_db($connect, $database);
            $error = '';
        } else {
            $connect = @mysql_connect($db_server, $db_username, $db_password);
            $select_db = @mysql_select_db($database, $connect);
            $error = mysql_errno().': '.mysql_error();
        }

        if( ! $connect ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "'.sprintf(lang('setup_step3_error_db_connect'), $db_server, $db_server, $error).'"}');
            return;
        }

        if( $connect && $select_db ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "true"}');
            return;
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "'.sprintf(lang('setup_step3_error_db'), $db_server, $database, $error).'"}');
            return;
        }
    }

    public function setup_config()
    {
        if( defined('installation_date') ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "Config file already exist!"}');
            return;
        }

        $license_key = trim($this->input->get('license_key2'));

        $db_driver = trim($this->input->get('driver'));
        $db_server = trim($this->input->get('db_server'));
        $db_username = trim($this->input->get('db_username'));
        $db_password = trim($this->input->get('db_password'));
        $db_prefix = trim($this->input->get('db_prefix'));
        $database = trim($this->input->get('database'));

        $site_url = trim($this->input->get('site_url'));
        $username = trim($this->input->get('username'));
        $password = trim($this->input->get('password'));
        $email = trim($this->input->get('email'));


        $validate_license = $this->simplece_model->validate_license($license_key);

        if( $validate_license === false ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "'.lang('settings_license_server_unavailable').'"}');
            return;
        } else {

            if( $validate_license['status'] != 'valid' ) {
                $this->output->set_content_type('application/json');
                $this->output->set_output('{"return": "'.$validate_license['message'].'"}');
                return;
            }

        }

        $this->load->helper('file');

        $example_config = read_file('config.example.php');

        if( ! $example_config ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "We can\'t open the config example file, please check config.example.php"}');
            return;
        }

        $this->load->helper('string');
        $encryption_key = random_string('alnum', 32);

        if( setup_lang == 'german' ) {
            $date_format = 'd.m.Y - H:i';
        } else {
            $date_format = 'm/d/Y - g:i a';
        }

        $setup_config = $example_config;
        $setup_config = str_replace('##Timestamp##', time(), $setup_config);
        $setup_config = str_replace('##Site-URL##', $site_url, $setup_config);
        $setup_config = str_replace('##DB-Driver##', $db_driver, $setup_config);
        $setup_config = str_replace('##DB-Server##', $db_server, $setup_config);
        $setup_config = str_replace('##DB-Username##', $db_username, $setup_config);
        $setup_config = str_replace('##DB-Password##', $db_password, $setup_config);
        $setup_config = str_replace('##DB-Database##', $database, $setup_config);
        $setup_config = str_replace('##DB-Prefix##', $db_prefix, $setup_config);
        $setup_config = str_replace('##Lang##', setup_lang, $setup_config);
        $setup_config = str_replace('##Encryption-Key##', $encryption_key, $setup_config);
        $setup_config = str_replace('##Date-Format##', $date_format, $setup_config);

        if ( ! write_file('config.php', $setup_config))
        {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "Unable to write the config file, please check the file permissions!"}');
            return;
        }
        else
        {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "true"}');
            return;
        }
    }

    public function setup_database_structure()
    {
        if( (time()-installation_date) >= 600 ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "Config file already exist and installation timed out!"}');
            return;
        }

        $license_key = trim($this->input->get('license_key2'));

        $db_driver = trim($this->input->get('driver'));
        $db_server = trim($this->input->get('db_server'));
        $db_username = trim($this->input->get('db_username'));
        $db_password = trim($this->input->get('db_password'));
        $db_prefix = trim($this->input->get('db_prefix'));
        $database = trim($this->input->get('database'));

        $site_url = trim($this->input->get('site_url'));
        $username = trim($this->input->get('username'));
        $password = trim($this->input->get('password'));
        $email = trim($this->input->get('email'));

        $this->load->database();
        $this->load->dbforge();

        $error = false;

        /**
         * Settings Table
         */
        $this->dbforge->add_field([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false,
                'auto_increment' => true
            ],
            'key' => [
                'type' => 'varchar',
                'constraint' => 64,
                'null' => false,
            ],
            'value' => [
                'type' => 'longtext',
                'null' => true
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);

        if( ! $this->dbforge->create_table(settings_table, TRUE) ) {
            $error = true;
        }

        /**
         * User Table
         */
        /*$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field('`username` varchar(100) NOT NULL');
        $this->dbforge->add_field('`password` varchar(32) NOT NULL');
        $this->dbforge->add_field('`email` varchar(200) NOT NULL');
        $this->dbforge->add_field('`firstname` varchar(200) DEFAULT NULL');
        $this->dbforge->add_field('`surname` varchar(200) DEFAULT NULL');
        $this->dbforge->add_field('`group` int(1) NOT NULL');*/

        $this->dbforge->add_field([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'varchar',
                'constraint' => 100,
                'null' => false,
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => 32,
                'null' => false,
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => false,
            ],
            'firstname' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => true,
            ],
            'surname' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => true,
            ],
            'group' => [
                'type' => 'int',
                'constraint' => 1,
                'null' => false,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);

        if( ! $this->dbforge->create_table(user_table, TRUE) ) {
            $error = true;
        }

        /**
         * Text Table
         */
        /*$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field('`sce_id` int(11) NOT NULL');
        $this->dbforge->add_field('`text` longtext NOT NULL');
        $this->dbforge->add_field('`type` varchar(16) NOT NULL');
        $this->dbforge->add_field('`loop_id` int(11) DEFAULT NULL');
        $this->dbforge->add_field('`loop_row` int(11) DEFAULT NULL');
        $this->dbforge->add_field('`created` datetime NOT NULL');
        $this->dbforge->add_field('`modified` datetime NOT NULL');*/

        $this->dbforge->add_field([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false,
                'auto_increment' => true
            ],
            'sce_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false
            ],
            'text' => [
                'type' => 'longtext',
                'null' => false
            ],
            'type' => [
                'type' => 'varchar',
                'constraint' => 16,
                'null' => false
            ],
            'loop_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true
            ],
            'loop_row' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true
            ],
            'created' => [
                'type' => 'datetime',
                'null' => false
            ],
            'modified' => [
                'type' => 'datetime',
                'null' => false
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('sce_id');

        if( ! $this->dbforge->create_table(text_table, TRUE) ) {
            $error = true;
        }

        /**
         * Image Table
         */
        /*$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field('`sce_id` int(11) NOT NULL');
        $this->dbforge->add_field('`path` varchar(400) NOT NULL');
        $this->dbforge->add_field('`alt` varchar(200) NOT NULL');
        $this->dbforge->add_field('`link` varchar(400) DEFAULT NULL');
        $this->dbforge->add_field('`lightbox` int(11) DEFAULT NULL');
        $this->dbforge->add_field('`loop_id` int(11) DEFAULT NULL');
        $this->dbforge->add_field('`loop_row` int(11) DEFAULT NULL');*/

        $this->dbforge->add_field([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false,
                'auto_increment' => true
            ],
            'sce_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false
            ],
            'path' => [
                'type' => 'varchar',
                'constraint' => 400,
                'null' => false
            ],
            'alt' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => false
            ],
            'link' => [
                'type' => 'varchar',
                'constraint' => 400,
                'null' => true
            ],
            'lightbox' => [
                'type' => 'int',
                'constraint' => 1,
                'null' => true
            ],
            'loop_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true
            ],
            'loop_row' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('sce_id');

        if( ! $this->dbforge->create_table(image_table, TRUE) ) {
            $error = true;
        }

        /**
         * File Table
         */
        /*$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field('`sce_id` int(11) NOT NULL');
        $this->dbforge->add_field('`path` varchar(500) NOT NULL');
        $this->dbforge->add_field('`text` varchar(200) NOT NULL');
        $this->dbforge->add_field('`loop_id` int(11) DEFAULT NULL');
        $this->dbforge->add_field('`loop_row` int(11) DEFAULT NULL');*/

        $this->dbforge->add_field([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false,
                'auto_increment' => true
            ],
            'sce_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false
            ],
            'path' => [
                'type' => 'varchar',
                'constraint' => 500,
                'null' => false
            ],
            'text' => [
                'type' => 'varchar',
                'constraint' => 200,
                'null' => false
            ],
            'loop_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true
            ],
            'loop_row' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('sce_id');

        if( ! $this->dbforge->create_table(file_table, TRUE) ) {
            $error = true;
        }

        /**
         * Loop Table
         */
        /*$this->dbforge->add_field('`id` int(11) NOT NULL AUTO_INCREMENT');
        $this->dbforge->add_field('`loop_id` int(11) NOT NULL');
        $this->dbforge->add_field('`rows` int(11) NOT NULL');*/

        $this->dbforge->add_field([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false,
                'auto_increment' => true
            ],
            'loop_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false
            ],
            'rows' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);

        if( ! $this->dbforge->create_table(loop_table, TRUE) ) {
            $error = true;
        }

        if( $error === false ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "true"}');
            return;
        } else {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "Unable to create the the needed database tables!"}');
            return;
        }
    }

    public function setup_database()
    {
        if( (time()-installation_date) >= 600 ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "Config file already exist and installation timed out!"}');
            return;
        }

        $license_key = trim($this->input->get('license_key2'));

        $db_driver = trim($this->input->get('driver'));
        $db_server = trim($this->input->get('db_server'));
        $db_username = trim($this->input->get('db_username'));
        $db_password = trim($this->input->get('db_password'));
        $db_prefix = trim($this->input->get('db_prefix'));
        $database = trim($this->input->get('database'));

        $site_url = trim($this->input->get('site_url'));
        $firstname = trim($this->input->get('firstname'));
        $surname = trim($this->input->get('surname'));
        $username = trim($this->input->get('username'));
        $password = trim($this->input->get('password'));
        $email = trim($this->input->get('email'));

        $demo_data = trim($this->input->get('demo-data'));


        $validate_license = $this->simplece_model->validate_license($license_key);

        if( $validate_license === false ) {
            $this->output->set_content_type('application/json');
            $this->output->set_output('{"return": "'.lang('settings_license_server_unavailable').'"}');
            return;
        } else {

            if( $validate_license['status'] != 'valid' ) {
                $this->output->set_content_type('application/json');
                $this->output->set_output('{"return": "'.$validate_license['message'].'"}');
                return;
            }

        }


        $this->load->database();

        $error = false;

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

        if( $demo_data == '1' ) {

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
        } else { // End of demo content
            @unlink(upload_path('test-image.gif'));
            @unlink(upload_path('test-image2.gif'));
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
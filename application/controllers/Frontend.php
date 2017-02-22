<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 02/07/14
 * Time: 20:12
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class frontend extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->lang->load('sce', language);
        $this->load->helper(array('language', 'frontend'));

        $this->load->database();
        $this->load->model('simplece_model');
        $this->load->model('user_model');
        $this->load->model('loop_model');

        $frontend_lightbox = $this->simplece_model->get_setting_val('disable_lightbox');

        define('sce_disable_lightbox', $frontend_lightbox);

        if( $this->simplece_model->get_setting_val('disable_cache', 'no') == 'no' ) {
            $this->load->driver('cache', array('adapter' => 'file'));
            define('use_cache', true);
        } else {
            define('use_cache', false);
        }

        if( is_logged_in() === true ) {
            define('frontend_user_is_logged_in', true);
        }
    }

    public function main()
    {

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 30.12.14
 * Time: 16:34
 */

class captcha_model extends CI_Model
{
    public function __construct()
    {
        if( get_setting('login_captcha', 'no') == 'yes' ) {
            $this->load->helper('captcha');
            $this->load->database();

            $this->check_setup();
        }
    }

    public function check_setup()
    {
        if( ! $this->db->table_exists(captcha_table) ) {
            $this->setup();
        }
    }

    public function setup()
    {
        $this->load->dbforge();

        $this->dbforge->add_field('`captcha_id` bigint(13) unsigned NOT NULL auto_increment');
        $this->dbforge->add_field('`captcha_time` int(10) unsigned NOT NULL');
        $this->dbforge->add_field('`ip_address` varchar(64) default \'0\' NOT NULL');
        $this->dbforge->add_field('`word` varchar(20) NOT NULL');
        $this->dbforge->add_key('captcha_id', TRUE);
        $this->dbforge->add_key('word', FALSE);

        if( ! $this->dbforge->create_table(captcha_table, TRUE) ) {
            return false;
        }

        if( ! is_dir(FCPATH.captcha_path_local.DS) ) {
            if( ! @mkdir(FCPATH.captcha_path_local.DS, DIR_WRITE_MODE) ) {
                return false;
            }
        }

        if( ! chmod(FCPATH.captcha_path_local.DS, DIR_WRITE_MODE) ) {
            return false;
        }

        return true;
    }

    public function garbage_collection()
    {
        $expiration = time() - captcha_expiration;
        $this->db->where('captcha_time <', $expiration);
        return $this->db->delete(captcha_table);
    }

    public function generate_captcha()
    {
        $cap_data = array(
            'img_path'	=> FCPATH.captcha_path_local.DS,
            'img_url'	=> base_url(captcha_path_web).'/',
            'font_path' => FCPATH.captcha_font,
            'img_width'	=> 268,
            'img_height' => 42,
            'expiration' => captcha_expiration
        );

        $cap = create_captcha($cap_data);

        if( is_array($cap) ) {
            $captcha_data = array(
                'captcha_time' => $cap['time'],
                'ip_address' => $this->input->ip_address(),
                'word'	=> $cap['word']
            );

            $this->db->insert(captcha_table, $captcha_data);
        } else {
            $cap = false;
        }

        return $cap;
    }

    public function validate_captcha($word, $ip)
    {
        $word = trim($word);

        if( empty($word) )
            return false;

        $this->db->where('word', $word);
        $this->db->where('ip_address', $ip);
        $this->db->where('captcha_time >', time() - captcha_expiration);
        $get = $this->db->get(captcha_table);

        if ($get->num_rows() >= 1)
        {
            return true;
        }

        return false;
    }
}
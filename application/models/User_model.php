<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 11/07/14
 * Time: 22:15
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model
{
    static $user_id = false;
    static $username = false;
    static $password = false;
    static $firstname = false;
    static $surname = false;
    static $group = false;

    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');

        if( $this->check_login() !== true && current_url() != site_url() && current_url() != site_url('reset-demo') ) {
            redirect(site_url());
            return;
        }
    }

    /**
     * Check if user is logged in and set the users profile information
     *
     * @return bool
     */
    public function check_login()
    {
        $username = $this->session->userdata('username');
        $password = $this->session->userdata('password');

        $user_id = $this->check_login_credentials( $username, $password, false );

        if( $user_id !== false && is_numeric($user_id) ) {
            $user = $this->get_user( $user_id );

            self::$user_id = $user['id'];
            self::$username = $user['username'];
            self::$password = $user['password'];
            self::$firstname = $user['firstname'];
            self::$surname = $user['surname'];
            self::$group = $user['group'];

            return true;
        }

        return false;
    }

    /**
     * Login data check
     *
     * @param string $username
     * @param string $password
     * @param bool $md5
     * @param bool $without_salt
     * @return bool
     */
    public function check_login_credentials($username, $password, $md5=true, $without_salt=false)
    {
        $t_username = trim($username);
        $t_password = trim($password);

        $decrypted_password = $password;

        if( empty($t_username) || empty($t_password) ) {
            return false;
        }

        if( $md5 === true ) {
            if ( $without_salt === true ) {
                $password = md5($password);
            } else {
                $password = md5($password.encryption_key);
            }

        }

        $this->db->select('id');
        $this->db->from(user_table);
        $this->db->where('username', $username);
        $this->db->where('password', $password);

        $get = $this->db->get();

        if( $get->num_rows() === 1 ) {
            $result = $get->result_array();
            $result = $result[0];

            return $result['id'];
        } else {

            if( $without_salt === false ) {
                $return = $this->check_login_credentials($username, $decrypted_password, true, true);

                if( $return !== false && is_numeric($return) ) {
                    $this->db->where('id', $return)->update(user_table, array(
                        'password' => md5($decrypted_password.encryption_key)
                    ));
                }

                return $return;
            }

            return false;
        }
    }

    /**
     * Get a list of all users
     *
     * @return bool|array
     */
    public function get_all_users()
    {
        $this->db->select('id, username, firstname, surname, email, group');
        $this->db->from(user_table);
        $this->db->order_by('id', 'ASC');
        $result = $this->db->get();

        if( $result->num_rows() >= 1) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    /**
     * Get a list of all users
     *
     * @param int $user_id
     * @return bool|array
     */
    public function get_user($user_id)
    {
        $this->db->select('*');
        $this->db->from(user_table);
        $this->db->where('id', $user_id);
        $this->db->order_by('id', 'ASC');
        $result = $this->db->get();

        if( $result->num_rows() >= 1) {
            $return = $result->result_array();

            return $return[0];
        } else {
            return false;
        }
    }

    /**
     * Update a user profile
     *
     * @param int $user_id
     * @param array $data
     * @return bool
     */
    public function update_user($user_id, $data)
    {
        $data_for_db = array(
            'username' => $data['username'],
            'email' => $data['email'],
            'firstname' => $data['firstname'],
            'surname' => $data['surname']
        );

        if( !empty($data['password']) || !empty($data['password2']) ) {
            $validate_password = $this->validate_password($data);
            if( $validate_password === true ) {
                $data_for_db['password'] = md5($data['password'].encryption_key);
            }
        }

        if( user_model::$group == 1 && $data['id'] != 1 ) {
            $data_for_db['group'] = $data['group'];
        }

        $update = $this->db->where('id', $user_id)->update(user_table, $data_for_db);

        return $update;
    }

    /**
     * Insert a new user profile
     *
     * @param array $data
     * @return bool|int
     */
    public function insert_user($data)
    {

        if( empty($data['group']) || ($data['group'] != 1 && $data['group'] != 2) ) {
            $data['group'] = 2;
        }

        $data_for_db = array(
            'username' => $data['username'],
            'password' => md5($data['password'].encryption_key),
            'email' => $data['email'],
            'firstname' => $data['firstname'],
            'surname' => $data['surname'],
            'group' => $data['group']
        );

        $insert = $this->db->insert(user_table, $data_for_db);

        if( $insert ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Delete a user account
     *
     * @param int $user_id
     * @return mixed
     */
    public function delete_user($user_id)
    {
        $this->db->where('id', $user_id);
        $del = $this->db->delete(user_table);

        return $del;
    }

    /**
     * Validate Userdata
     *
     * @param array $data
     * @param bool $force_pw
     * @return array|bool
     */
    public function validate_user($data, $force_pw=false)
    {
        $error = false;
        $error_msg = array();

        if( empty($data['username']) || strlen($data['username']) <= 4 || strlen($data['username']) >= 100 ) {
            $error = true;
            array_push($error_msg, lang('user_validate_msg_username'));
        }

        if( !$this->check_username_already_exists($data['username'], $data['id']) ) {
            $error = true;
            array_push($error_msg, lang('user_validate_msg_username2'));
        }

        if( empty($data['email']) || strlen($data['email']) <= 4 || strlen($data['email']) >= 200 || !valid_email($data['email']) ) {
            $error = true;
            array_push($error_msg, lang('user_validate_msg_email'));
        }

        if( !$this->check_email_already_exists($data['email'], $data['id']) ) {
            $error = true;
            array_push($error_msg, lang('user_validate_msg_email2'));
        }

        if( !empty($data['firstname']) && (strlen($data['firstname']) <= 2 || strlen($data['firstname']) >= 200) ) {
            $error = true;
            array_push($error_msg, lang('user_validate_msg_firstname'));
        }

        if( !empty($data['surname']) && (strlen($data['surname']) <= 2 || strlen($data['surname']) >= 200) ) {
            $error = true;
            array_push($error_msg, lang('user_validate_msg_surname'));
        }

        if( user_model::$group == 1 && $data['id'] != 1 ) {
            if( $data['group'] != '1' && $data['group'] != '2' ) {
                $error = true;
                array_push($error_msg, lang('user_validate_msg_usergroup'));
            }
        }

        if( (!empty($data['password']) || !empty($data['password2'])) || $force_pw == true ) {
            $validate_password = $this->validate_password($data);
            if( $validate_password !== true ) {
                $error = true;

                foreach( $validate_password['message'] as $msg ) {
                    array_push($error_msg, $msg);
                }
            }
        }

        /**
         * Return
         */
        if( $error === false ) {
            return true;
        } else {
            return array(
                'status' => 'error',
                'message' => $error_msg
            );
        }

    }

    /**
     * Check if the given mail address is already in use
     *
     * @param string $email
     * @param bool|int $allowed_id
     * @return bool
     */
    public function check_email_already_exists($email, $allowed_id=false)
    {
        $this->db->select('id, email');
        $this->db->from(user_table);
        $this->db->where('email', $email);
        if( $allowed_id !== false ) {
            $this->db->where('id !=', $allowed_id);
        }
        $get = $this->db->get();

        if( $get->num_rows() == 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the given username is already in use
     *
     * @param string $username
     * @param bool|int $allowed_id
     * @return bool
     */
    public function check_username_already_exists($username, $allowed_id=false)
    {
        $this->db->select('id, username');
        $this->db->from(user_table);
        $this->db->where('username', $username);
        if( $allowed_id !== false ) {
            $this->db->where('id !=', $allowed_id);
        }
        $get = $this->db->get();

        if( $get->num_rows() == 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validate the users password
     *
     * @param array $data
     * @return array|bool
     */
    public function validate_password($data)
    {
        $error = true;
        $error_msg = array();

        if( !empty($data['password']) || !empty($data['password2']) ) {

            if( $data['password'] === $data['password2'] ) {

                if( strlen($data['password']) >= 4 && strlen($data['password']) <= 32 ) {
                    $error = false;
                } else {
                    $error = true;
                    array_push($error_msg, lang('user_validate_msg_password'));
                }

            } else {
                $error = true;
                array_push($error_msg, lang('user_validate_msg_password2'));
            }

        } elseif ( empty($data['password']) && empty($data['password2']) ) {
            $error = false;
        }


        /**
         * Return
         */
        if( $error === false ) {
            return true;
        } else {
            return array(
                'status' => 'error',
                'message' => $error_msg
            );
        }
    }

    /**
     * Check User-Rights
     *
     * @param string $key
     * @param string|bool $group
     * @return bool
     */
    public function can_user_access( $key, $group=false )
    {
        if( $group === false ) {
            $group = self::$group;
        }

        if( $group == 1 )
            return true;

        if( $group != 1 && $group != 2 ) {
            return false;
        }

        $setting = $this->simplece_model->get_setting_val('user_'.$key.'_menu', 'no');
        $setting = strtolower($setting);

        if( $setting == 'yes' ) {
            return true;
        }

        return false;
    }

    /**
     * Public Static Port of "Check User-Rights"
     *
     * @param string $key
     * @param string|bool $group
     * @return bool
     */
    public static function _can_user_access( $key, $group=false )
    {
        return self::can_user_access( $key, $group=false );
    }

}
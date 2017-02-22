<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 09/07/14
 * Time: 19:46
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class file_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Load a list with all file Elements
     *
     * @return bool
     */
    public function get_content_list()
    {
        $this->db->select('id, sce_id, path, text');
        $this->db->from(file_table);
        $this->db->order_by('sce_id', 'ASC');
        $result = $this->db->get();

        if( $result->num_rows() >= 1 ) {
            $return = $result->result_array();
            return $return;
        } else {
            return false;
        }
    }

    /**
     * Search in Files
     *
     * @param string $q
     * @return bool|array
     */
    public function search_content_list($q)
    {
        $this->db->select('id, sce_id, path, text');
        $this->db->from(file_table);
        $this->db->like('sce_id', $q);
        $this->db->or_like('path', $q);
        $this->db->or_like('text', $q);
        $this->db->order_by('sce_id', 'ASC');
        $result = $this->db->get();

        if( $result->num_rows() >= 1 ) {
            $return = $result->result_array();
            return $return;
        } else {
            return false;
        }
    }

    /**
     * Load a file from the database by its id
     *
     * @param int $id
     * @param string $id_type
     * @return bool|array
     */
    public function get_file($id, $id_type='id')
    {
        $this->db->select('*');
        $this->db->from(file_table);
        if( $id_type == 'sce_id' ) {
            $this->db->where('sce_id', $id);
        } else {
            $this->db->where('id', $id);
        }

        if( loop_model::$loopID !== false && loop_model::$loopI !== false ) {
            $this->db->where('loop_id', loop_model::$loopID);
            $this->db->where('loop_row', loop_model::$loopI);
        } else if( $id_type != 'id' ) {
            $this->db->where('loop_id IS NULL');
            $this->db->where('loop_row IS NULL');
        }

        $this->db->order_by('sce_id', 'ASC');
        $result = $this->db->get();

        if( $result->num_rows() >= 1 ) {
            $return = $result->result_array();
            return $return[0];
        } else {
            return false;
        }
    }

    /**
     * Create a File element
     *
     * @param array $data
     * @return bool mixed
     */
    public function create_file($data)
    {
        $insert_data = array(
            'sce_id' => $data['sce_id'],
            'path' => $data['path'],
            'text' => $data['text']
        );

        if( loop_model::$loopID !== false && loop_model::$loopI !== false ) {
            $insert_data['loop_id'] = loop_model::$loopID;
            $insert_data['loop_row'] = loop_model::$loopI;
        }

        $insert = $this->db->insert(file_table, $insert_data);

        if( $insert ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Updates a file element
     *
     * @param int $id
     * @param array $data
     * @return bool mixed
     */
    public function update_file($id, $data)
    {

        $update_array = array(
            'sce_id' => $data['sce_id'],
            'path' => $data['path'],
            'text' => $data['text']
        );

        if( $data['path'] === false /*|| empty($data['path'])*/ ) {
            unset($update_array['path']);
        } else {

            $old_file = $this->get_file( $id );

            if( $old_file ) {
                $this->load->helper('file');
                if( $old_file['path'] != $update_array['path'] ) {
                    @unlink(FCPATH.uploads_dir.DS.$old_file['path']);
                }
            }
        }

        $this->db->where('id', $id);
        $update = $this->db->update(file_table, $update_array);

        if( use_cache === true ) {
            //$this->cache->delete('file-'.$data['sce_id']);
            $this->cache->clean();
        }

        return $update;
    }

    /**
     * Upload function for new files
     *
     * @return array
     */
    public function do_upload()
    {

        if( !isset($_FILES['upload']['name']) || empty($_FILES['upload']['name']) ) {
            return array(
                'status' => true,
                'file' => false
            );
        }

        /**
         * Upload Settings
         */
        $config['upload_path'] = FCPATH.uploads_dir.DS;
        $config['allowed_types'] = allowed_files;
        $config['max_size']	= 0;

        /* Load Upload Library */
        $this->load->library('upload', $config);

        /**
         * Do Upload
         */
        if ( !$this->upload->do_upload('upload'))
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

    /**
     * Validates a file array
     *
     * @param array $data
     * @return array|bool
     */
    public function validate_file($data)
    {
        $error = false;
        $error_msg = array();

        /**
         * Validation
         */
        if( !is_numeric($data['id']) || empty($data['id']) || $data['id'] <= 0 ) {
            $error = true;
            array_push($error_msg, lang('ct_validation_id'));
        }

        if( !is_numeric($data['sce_id']) || empty($data['sce_id']) || $data['sce_id'] <= 0 ) {
            $error = true;
            array_push($error_msg, lang('ct_validation_id'));
        }

        if( strlen($data['path']) > 400 ) {
            $error = true;
            array_push($error_msg, lang('ct_file_validation_path'));
        }

        if( strlen($data['text']) > 200 ) {
            $error = true;
            array_push($error_msg, lang('ct_file_validation_text'));
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

    public function delete($id)
    {
        $file = $this->get_file($id);

        if( !empty($file['path']) ) {
            @unlink(upload_path($file['path']));
        }

        return $this->db->delete(file_table, array('id' => $id));
    }
}
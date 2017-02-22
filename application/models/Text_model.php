<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 04/07/14
 * Time: 23:22
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class text_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Allowed types for the text element
     *
     * @return array
     */
    public function allowed_types()
    {
        return array('editor', 'html', 'long', 'short');
    }

    /**
     * Load a list with all Text Elements
     *
     * @return bool|array
     */
    public function get_content_list()
    {
        $this->db->select('id, sce_id, text, type');
        $this->db->from(text_table);
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
     * Search in Text
     *
     * @param string $q
     * @return bool|array
     */
    public function search_content_list($q)
    {
        $this->db->select('id, sce_id, text, type');
        $this->db->from(text_table);
        $this->db->like('sce_id', $q);
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
     * Load a text from the database by its id
     *
     * @param int $id
     * @param string $id_type
     * @return bool|array
     */
    public function get_text($id, $id_type='id')
    {
        $this->db->select('*');
        $this->db->from(text_table);
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
     * Updates a text element
     *
     * @param int $id
     * @param array $data
     * @return bool mixed
     */
    public function update_text($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update(text_table, array(
            'sce_id' => $data['sce_id'],
            'text' => $data['text'],
            'type' => $data['type'],
            'modified' => date('Y-m-d H:i:s')
        ));

        if( use_cache === true ) {
            //$this->cache->delete('text-'.$data['sce_id']);
            $this->cache->clean();
        }

        return $update;
    }

    /**
     * Create a text element
     *
     * @param array $data
     * @return bool mixed
     */
    public function create_text($data)
    {
        $insert_data = array(
            'sce_id' => $data['sce_id'],
            'text' => $data['text'],
            'type' => $data['type'],
            'modified' => date('Y-m-d H:i:s'),
            'created' => date('Y-m-d H:i:s')
        );

        if( loop_model::$loopID !== false && loop_model::$loopI !== false ) {
            $insert_data['loop_id'] = loop_model::$loopID;
            $insert_data['loop_row'] = loop_model::$loopI;
        }

        $insert = $this->db->insert(text_table, $insert_data);

        if( $insert ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Validates a text array
     *
     * @param array $data
     * @return array|bool
     */
    public function validate_text($data)
    {
        $error = false;
        $error_msg = array();
        $types = $this->allowed_types();

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

        if( !in_array($data['type'], $types) ) {
            $error = true;
            array_push($error_msg, lang('ct_txt_validation_type'));
        }

        if( strlen($data['text']) > 4000000000 ) {
            $error = true;
            array_push($error_msg, lang('ct_txt_validation_text'));
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
        return $this->db->delete(text_table, array('id' => $id));
    }
}
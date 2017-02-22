<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 06/07/14
 * Time: 16:16
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class image_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Load a list with all Image Elements
     *
     * @return bool
     */
    public function get_content_list()
    {
        $this->db->select('id, sce_id, path, alt');
        $this->db->from(image_table);
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
     * Search in Images
     *
     * @param string $q
     * @return bool|array
     */
    public function search_content_list($q)
    {
        $this->db->select('id, sce_id, path, alt');
        $this->db->from(image_table);
        $this->db->like('sce_id', $q);
        $this->db->or_like('path', $q);
        $this->db->or_like('alt', $q);
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
     * Load an image from the database by its id
     *
     * @param int $id
     * @param string $id_type
     * @return bool|array
     */
    public function get_image($id, $id_type='id')
    {
        $this->db->select('*');
        $this->db->from(image_table);
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
     * Updates an image element
     *
     * @param int $id
     * @param array $data
     * @return bool mixed
     */
    public function update_image($id, $data)
    {

        $update_array = array(
            'sce_id' => $data['sce_id'],
            'path' => $data['path'],
            'alt' => $data['alt'],
            'link' => $data['link'],
            'lightbox' => (($data['lightbox']==1)?1:0)
        );

        if( $data['path'] === false /*|| empty($data['path'])*/ ) {
            unset($update_array['path']);
        } else {

            $old_image = $this->get_image( $id );

            if( $old_image ) {
                $this->load->helper('file');
                if( $old_image['path'] != $update_array['path'] ) {
                    @unlink(FCPATH.uploads_dir.DS.$old_image['path']);
                }
            }
        }

        $this->db->where('id', $id);
        $update = $this->db->update(image_table, $update_array);

        if( use_cache === true ) {
            //$this->cache->delete('image-'.$data['sce_id']);
            $this->cache->clean();
        }

        return $update;
    }

    /**
     * Create an Image element
     *
     * @param array $data
     * @return bool mixed
     */
    public function create_image($data)
    {
        $insert_data = array(
            'sce_id' => $data['sce_id'],
            'path' => $data['path'],
            'alt' => $data['alt'],
            'link' => $data['link'],
            'lightbox' => (($data['lightbox']==1)?1:0)
        );

        if( loop_model::$loopID !== false && loop_model::$loopI !== false ) {
            $insert_data['loop_id'] = loop_model::$loopID;
            $insert_data['loop_row'] = loop_model::$loopI;
        }

        $insert = $this->db->insert(image_table, $insert_data);

        if( $insert ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Upload function for new images
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
        $config['allowed_types'] = allowed_images;
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
     * Validates an image array
     *
     * @param array $data
     * @return array|bool
     */
    public function validate_image($data)
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
            array_push($error_msg, lang('ct_img_validation_path'));
        }

        if( strlen($data['alt']) > 200 ) {
            $error = true;
            array_push($error_msg, lang('ct_img_validation_alt'));
        }

        if( strlen($data['link']) > 400 ) {
            $error = true;
            array_push($error_msg, lang('ct_img_validation_link'));
        }

        if( $data['lightbox'] != 0 && $data['lightbox'] != 1 ) {
            $error = true;
            array_push($error_msg, lang('ct_img_validation_lightbox'));
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
        $image = $this->get_image($id);

        if( !empty($image['path']) ) {
            @unlink(upload_path($image['path']));
        }

        return $this->db->delete(image_table, array('id' => $id));
    }
}
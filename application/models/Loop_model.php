<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 01/08/14
 * Time: 10:51 PM
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class loop_model extends CI_Model
{
    static $loopID = false;
    static $loopI = false;
    static $loops = false;
    private $content_tables = false;

    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');

        $this->content_tables = array(text_table, image_table, file_table);
    }

    public function create_loop($loop_id)
    {
        $insert = $this->db->insert(loop_table, array(
            'loop_id' => $loop_id,
            'rows' => 1
        ));

        if( $insert ) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function get_loop($loop_id)
    {
        $this->db->select('*');
        $this->db->from(loop_table);
        $this->db->where('loop_id', $loop_id);
        $get = $this->db->get();

        if( $get->num_rows() == 1 ) {
            $result = $get->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function add_row($loop_id, $row=false)
    {
        $this->db->where('loop_id', $loop_id);
        $this->db->set('rows', 'rows+1', false);
        $update = $this->db->update(loop_table);

        if( $row !== false ):
            foreach( $this->content_tables as $table ) {
                $this->db->select('*');
                $this->db->from($table);
                $this->db->where('loop_id', $loop_id);
                $this->db->where('loop_row >', $row, false);
                $get = $this->db->get();

                if( $get->num_rows() >= 1 ) {
                    $results = $get->result_array();

                    foreach( $results as $result ) {
                        $this->db->where('id', $result['id']);
                        $this->db->set('loop_row', 'loop_row+1', false);
                        $update2 = $this->db->update($table);
                    }
                }
            }
        endif;

        if( $update ) {
            return true;
        } else {
            return false;
        }
    }

    public function del_row($loop_id, $row)
    {
        $this->del_texts($loop_id, $row);
        $this->del_images($loop_id, $row);
        $this->del_files($loop_id, $row);

        $this->db->where('loop_id', $loop_id);
        $this->db->set('rows', 'rows-1', false);
        $update = $this->db->update(loop_table);

        foreach( $this->content_tables as $table ) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('loop_id', $loop_id);
            $this->db->where('loop_row >', $row, false);
            $get = $this->db->get();

            if( $get->num_rows() >= 1 ) {
                $results = $get->result_array();

                foreach( $results as $result ) {
                    $this->db->where('id', $result['id']);
                    $this->db->set('loop_row', 'loop_row-1', false);
                    $update2 = $this->db->update($table);
                }
            }
        }

        if( $update ) {
            return true;
        } else {
            return false;
        }
    }

    public function del_texts($loop_id, $row)
    {
        $del = $this->db->delete(text_table, array(
            'loop_id' => $loop_id,
            'loop_row' => $row
        ));

        return $del;
    }

    public function del_images($loop_id, $row)
    {
        $get = $this->db->get_where(image_table, array(
            'loop_id' => $loop_id,
            'loop_row' => $row
        ));

        if( $get->num_rows() >= 1 ) {
            $result = $get->result_array();

            foreach( $result as $item ) {
                if( !empty($item['path']) ) {
                    @unlink(upload_path($item['path']));
                }
            }
        }

        $del = $this->db->delete(image_table, array(
            'loop_id' => $loop_id,
            'loop_row' => $row
        ));

        return $del;
    }

    public function del_files($loop_id, $row)
    {
        $get = $this->db->get_where(file_table, array(
            'loop_id' => $loop_id,
            'loop_row' => $row
        ));

        if( $get->num_rows() >= 1 ) {
            $result = $get->result_array();

            foreach( $result as $item ) {
                if( !empty($item['path']) ) {
                    @unlink(upload_path($item['path']));
                }
            }
        }

        $del = $this->db->delete(file_table, array(
            'loop_id' => $loop_id,
            'loop_row' => $row
        ));

        return $del;
    }

    public function get_elements_for_row($row, $loop_id)
    {
        $return = array();

        /*
         * Load Text
         */
        $this->db->select('id, sce_id, loop_id, loop_row');
        $this->db->from(text_table);
        $this->db->where('loop_id', $loop_id);
        $this->db->where('loop_row', $row);
        $get_text = $this->db->get();

        if( $get_text->num_rows() >= 1 ) {
            $return['text'] = $get_text->result_array();
        } else {
            $return['text'] = false;
        }

        /*
         * Load Images
         */
        $this->db->select('id, sce_id, loop_id, loop_row');
        $this->db->from(image_table);
        $this->db->where('loop_id', $loop_id);
        $this->db->where('loop_row', $row);
        $get_images = $this->db->get();

        if( $get_images->num_rows() >= 1 ) {
            $return['images'] = $get_images->result_array();
        } else {
            $return['images'] = false;
        }

        /*
         * Load Files
         */
        $this->db->select('id, sce_id, loop_id, loop_row');
        $this->db->from(file_table);
        $this->db->where('loop_id', $loop_id);
        $this->db->where('loop_row', $row);
        $get_files = $this->db->get();

        if( $get_files->num_rows() >= 1 ) {
            $return['files'] = $get_files->result_array();
        } else {
            $return['files'] = false;
        }

        return $return;
    }

    public function set_new_row_for_elements($row, $elements)
    {
        if( is_array($elements['text']) && $elements['text'] != false ) {
            foreach($elements['text'] as $content){
                $this->db->where('id', $content['id']);
                $this->db->set('loop_row', $row);
                $this->db->update(text_table);
            }
        }

        if( is_array($elements['images']) && $elements['images'] != false ) {
            foreach($elements['images'] as $content){
                $this->db->where('id', $content['id']);
                $this->db->set('loop_row', $row);
                $this->db->update(image_table);
            }
        }

        if( is_array($elements['files']) && $elements['files'] != false ) {
            foreach($elements['files'] as $content){
                $this->db->where('id', $content['files']);
                $this->db->set('loop_row', $row);
                $this->db->update(file_table);
            }
        }
    }
}
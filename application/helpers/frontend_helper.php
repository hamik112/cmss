<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 23/07/14
 * Time: 22:32
 */

function sce_head( $vars=array() )
{
    $lightbox = true;
    $font_awesome = false;

    if( is_array($vars) && count($vars) >= 1 ) {
        extract($vars, EXTR_OVERWRITE);
    }

    $CI =& get_instance();

    @is_logged_in();

    if( $lightbox != false ) {
        echo "\n\t".'<link rel="stylesheet" href="'.base_url('assets/nivo-lightbox/nivo-lightbox.css').'" />'."\n";
        echo "\t".'<link rel="stylesheet" href="'.base_url('assets/nivo-lightbox/themes/default/default.css').'" />'."\n";
    }

    if( is_logged_in() === true ) {
        echo "\n\t".'<link rel="stylesheet" href="'.base_url('assets/css/font-awesome.min.css').'" />'."\n";
        echo "\t".'<link rel="stylesheet" href="'.base_url('assets/css/frontend.css').'" />'."\n";

        $color1 = get_setting('fe_color_1', fe_color_1);
        $color2 = get_setting('fe_color_2', fe_color_2);

        if( $color1 != fe_color_1 || $color2 != fe_color_2 ):
        echo "\t".'<style>'."\n";
        echo "\t".'.sce_inline_editor:hover, .sce_editor:hover {border-color: '.$color1.';}'."\n";
        echo "\t".'.sce_edit_button, .sce_edit_button:hover {background-color: '.$color1.'; color: '.$color2.'; }'."\n";
        echo "\t".'.sce_edit_button_small, .sce_edit_button_small:hover {color: '.$color1.';}'."\n";

        echo "\t".'.nivo-lightbox-wrap {max-width: 1028px !important;}'."\n";

        echo "\t".'</style>'."\n";
        endif;

        echo "\t".'<style>'."\n";
        echo "\t".'.nivo-lightbox-wrap {max-width: 1028px !important;}'."\n";
        echo "\t".'</style>'."\n";
    } else {
        if( $font_awesome == true ) {
            echo "\n\t".'<link rel="stylesheet" href="'.base_url('assets/css/font-awesome.min.css').'" />'."\n";
        }
    }
}

function sce_footer( $vars=array() )
{
    $jquery = true;
    $lightbox = true;

    if( is_array($vars) && count($vars) >= 1 ) {
        extract($vars, EXTR_OVERWRITE);
    }

    $CI =& get_instance();

    if( is_logged_in() === true ) {
        echo $CI->load->view('frontend_navi', '', true);

        echo "\n\t".'<script>'."\n";
        echo "\t".'var sce_ajax_url = \''.site_url('ajax').'\';'."\n";
        echo "\t".'var sce_editor_mode = \''.get_setting('editor_mode').'\';'."\n";
        echo "\t".'var sce_ajax_url = \''.site_url('ajax').'\';'."\n";
        echo "\t".'var sce_filebrowserImageUploadUrl = \''.site_url('ajax/cke-upload').'\';'."\n";
        echo "\t".'var sce_disable_lightbox = \''.sce_disable_lightbox.'\';'."\n";
        echo "\t".'var sce_code_style = \''.get_setting('code_style').'\';'."\n";
        if( language == 'german' ) {
            echo "\t".'var sce_lang = \'de\';'."\n";
        } else {
            echo "\t".'var sce_lang = \'en\';'."\n";
        }
        echo "\t".'</script>'."\n";
        if( $jquery === true ) {
            echo "\t".'<script src="'.base_url('assets/js/vendor/jquery.js').'"></script>'."\n";
        } elseif( $jquery == 'v1' ) {
	        echo "\t".'<script src="'.base_url('assets/js/vendor/jquery-1.11.3.js').'"></script>'."\n";
        }
        echo "\t".'<script src="'.base_url('assets/nivo-lightbox/nivo-lightbox.min.js').'"></script>'."\n";
        echo "\t".'<script src="'.base_url('assets/ckeditor/ckeditor.js').'"></script>'."\n";
        echo "\t".'<script src="'.base_url('assets/js/frontend.min.js').'"></script>'."\n";
    } else {
        if( $jquery === true ) {
            echo "\t".'<script src="'.base_url('assets/js/vendor/jquery.js').'"></script>'."\n";
        } elseif( $jquery == 'v1' ) {
	        echo "\t".'<script src="'.base_url('assets/js/vendor/jquery-1.11.3.js').'"></script>'."\n";
        }

        if( $lightbox == true ) {
            echo "\t".'<script src="'.base_url('assets/nivo-lightbox/nivo-lightbox.min.js').'"></script>'."\n";

            echo "\n\t".'<script>'."\n";
            echo "\t".'jQuery(document).ready(function(){ jQuery(\'.sce_image_lightbox\').nivoLightbox(); });'."\n";
            echo "\t".'</script>'."\n";
        }
    }
}

function is_logged_in()
{
    $CI =& get_instance();

    return $CI->user_model->check_login();
}

function sce_editor($sce_id, $type, $vars=array())
{
    $CI =& get_instance();
    $CI->load->model('text_model');

    /**
     * Default-Settings
     */
    $mode = 'modal';
    $before = '';
    $after = '';
    $return = false;
    $auto_typography = false;

    if( is_array($vars) && count($vars) >= 1 ) {
        extract($vars, EXTR_OVERWRITE);
    }

    $type = strtolower($type);

    if( use_cache === true ) {

        if( loop_model::$loopID !== false && loop_model::$loopI !== false ) {
            $cache_id = 'text-'.$sce_id.'--'.loop_model::$loopID.'-'.loop_model::$loopI;
        } else {
            $cache_id = 'text-'.$sce_id;
        }


        if ( ! $cache = $CI->cache->get($cache_id)) {
            $text = $CI->text_model->get_text($sce_id, 'sce_id');

            if( $text !== false ) {
                $CI->cache->save($cache_id, serialize($text), cache_ttl);
            }
        } else {
            $text = unserialize($cache);
        }

    } else {
        $text = $CI->text_model->get_text($sce_id, 'sce_id');
    }

    if( $text == false ) {
        $insert_id = $CI->text_model->create_text(array(
            'sce_id' => $sce_id,
            'text' => '',
            'type' => $type,
        ));

        $text = array(
            'sce_id' => $sce_id,
            'text' => '',
            'type' => $type,
        );

        if( $insert_id && is_numeric($insert_id) ) {
            $text['id'] = $insert_id;
        }
    }

    if( $mode == 'inline' && $type != 'html' ) {
        $class = 'sce_inline_editor';
    } else {
        $class = 'sce_editor';
    }

    if( is_logged_in() === true ) {
        echo '<div class="sce_editable_area sce_type_'.$type.'">';
        echo $before.'<div class="'.$class.'" data-id="'.$text['sce_id'].'" data-loop="'.((loop_model::$loopID)?loop_model::$loopID:0).'" data-row="'.((loop_model::$loopI)?loop_model::$loopI:0).'" data-type="'.$type.'" '.(($mode=='inline' && $type != 'html')?'contenteditable="true"':'').'>';

        if ($type == 'long' || $type == 'short') {
            $text['text'] = strip_tags($text['text']);
        }

        if( $auto_typography == true ) {
            $CI->load->library('typography');

            echo $CI->typography->auto_typography($text['text']);
        } else {
            echo $text['text'];
        }


        echo '</div>';

        if( $type == 'editor' || $type == 'long' || $type == 'html' ) {
            echo '<a href="'.site_url('content/text/'.$text['id'].'?return_url='.urlencode(return_url())).'" class="sce_edit_button" data-lightbox-type="iframe"><i class="fa fa-pencil-square"></i> &nbsp; '.lang('fe_edit').'</a>';
        } elseif( $type == 'short' ) {
            echo '&nbsp; <a href="'.site_url('content/text/'.$text['id'].'?return_url='.urlencode(return_url())).'" class="sce_edit_button_small" data-lightbox-type="iframe"><i class="fa fa-pencil-square"></i></a>';
        }

        echo $after.'</div>';
    } else {
        if( $auto_typography == true ) {
            $CI->load->library('typography');

            $text['text'] = $CI->typography->auto_typography($text['text']);
        }

        if( !empty($text['text']) ) {
            $return_text = $before.$text['text'].$after;
        } else {
            $return_text = $text['text'];
        }

        if( $return == true ) {
            return $return_text;
        } else {
            echo $return_text;
        }
    }
}

function sce_image($sce_id, $vars=array())
{
    $CI =& get_instance();
    $CI->load->model('image_model');

    /**
     * Default-Settings
     */
    $before = '';
    $after = '';
    $class = '';
    $id = '';
    $rel = '';
    $custom_attributes_a = '';
    $custom_attributes_img = '';
    $target = '_self';
    $return = false;
    $thumb_width = false;
    $thumb_height = false;
    $crop = false;
    $gallery_name = false;

    if( is_array($vars) && count($vars) >= 1 ) {
        extract($vars, EXTR_OVERWRITE);
    }

    if( use_cache === true ) {

        if( loop_model::$loopID !== false && loop_model::$loopI !== false ) {
            $cache_id = 'image-'.$sce_id.'--'.loop_model::$loopID.'-'.loop_model::$loopI;
        } else {
            $cache_id = 'image-'.$sce_id;
        }

        if ( ! $cache = $CI->cache->get($cache_id)) {
            $image = $CI->image_model->get_image($sce_id, 'sce_id');

            if( $image !== false ) {
                $CI->cache->save($cache_id, serialize($image), cache_ttl);
            }
        } else {
            $image = unserialize($cache);
        }

    } else {
        $image = $CI->image_model->get_image($sce_id, 'sce_id');
    }

    if( $image == false ) {
        $insert_id = $CI->image_model->create_image(array(
            'sce_id' => $sce_id,
            'path' => '',
            'alt' => '',
            'link' => '',
            'lightbox' => 0
        ));

        $image = array(
            'sce_id' => $sce_id,
            'path' => '',
            'alt' => '',
            'link' => '',
            'lightbox' => 0
        );

        if( $insert_id && is_numeric($insert_id) ) {
            $image['id'] = $insert_id;
        }
    }

    if( !empty($image['path']) ) {
        $return_image = $before;

        if ( $image['lightbox'] == 1 ) {
            $return_image .= '<a href="'.upload_url($image['path']).'" title="'.html_escape($image['alt']).'" class="sce_image_lightbox" '.(($gallery_name!=false)?'data-lightbox-gallery="'.$gallery_name.'"':'').' '.(($rel)?'rel="'.$rel.'"':'').' '.$custom_attributes_a.'>';
        } elseif ( !empty($image['link']) ) {
            $return_image .= '<a href="'.$image['link'].'" title="'.html_escape($image['alt']).'" target="'.$target.'" '.(($rel)?'rel="'.$rel.'"':'').' '.$custom_attributes_a.'>';
        }

        if( ($thumb_width != false && $thumb_height != false) && (is_numeric($thumb_width) && is_numeric($thumb_height)) ) {

            $extension = end(explode('.', $image['path']));
            $file = str_replace('.'.$extension, '', $image['path']);

            $thumb_file = $file.'_'.$thumb_width.'x'.$thumb_height.'.'.$extension;
            $cache_path = upload_path(thumb_cache_dir.DS.$thumb_file);

            if ( file_exists($cache_path) ) {
                $thumb_return = upload_url(thumb_cache_dir.'/'.$thumb_file);
            } else {

                if( ! is_dir(upload_path(thumb_cache_dir.DS)) ) {
                    @mkdir(upload_path(thumb_cache_dir.DS), DIR_WRITE_MODE, true);
                }

                $CI->load->library('image_lib');

                if( extension_loaded('gd') && function_exists('gd_info') ) {
                    $config['image_library'] = 'gd2';
                } elseif( extension_loaded('imagick') && class_exists('Imagick') ) {
                    $config['image_library'] = 'imagick';
                } else {
                    echo 'You have not installed an compatible image manipulation library, so you can\'t use thumbnails in simpleCE!';
                }

                $config['source_image']	= upload_path($image['path']);
                $config['new_image'] = upload_path(thumb_cache_dir.DS.$thumb_file);
                $config['quality'] = thumb_quality;
                $config['maintain_ratio'] = $crop;
                $config['width'] = $thumb_width;
                $config['height'] = $thumb_height;

                $CI->image_lib->initialize($config);

                if ( $CI->image_lib->resize()) {
                    $thumb_return = upload_url(thumb_cache_dir.'/'.$thumb_file);
                } else {
                    $thumb_return = upload_url($image['path']);
                }
            }

            $return_array = array(
                'src' => $thumb_return,
                'alt' => $image['alt'],
                'lightbox' => $image['lightbox'],
                'link' => $image['link']
            );

            $return_image .= '<img src="'.$thumb_return.'" alt="'.html_escape($image['alt']).'" class="'.$class.'" id="'.$id.'" '.$custom_attributes_img.' />';
        } else {

            $return_array = array(
                'src' => upload_url($image['path']),
                'alt' => $image['alt'],
                'lightbox' => $image['lightbox'],
                'link' => $image['link']
            );

            $return_image .= '<img src="'.upload_url($image['path']).'" alt="'.html_escape($image['alt']).'" class="'.$class.'" id="'.$id.'" '.$custom_attributes_img.' />';
        }

        if ( $image['lightbox'] == 1 || !empty($image['link']) ) {
            $return_image .= '</a>';
        }

        $return_image .= $after;
    } else {
        $return_image = '';
        $return_array = false;
    }

    if( is_logged_in() === true ) {
        echo '<span class="sce_editable_area sce_type_image">';

        echo $return_image;

        echo '<a href="'.site_url('content/image/'.$image['id'].'?return_url='.urlencode(return_url())).'" class="sce_edit_button" data-lightbox-type="iframe"><i class="fa fa-pencil-square"></i> &nbsp; '.lang('fe_edit').'</a>';

        echo '</span>';
    } else {

        if( $return === true ) {
            return $return_image;
        } elseif( $return == 'array' ) {
            return $return_array;
        } else {
            echo $return_image;
        }
    }
}

function sce_file($sce_id, $vars=array())
{
    $CI =& get_instance();
    $CI->load->model('file_model');

    /**
     * Default-Settings
     */
    $before = '';
    $after = '';
    $id = '';
    $class = 'sce_file_element';
    $custom_attributes_a = '';
    $target = '_blank';
    $return = false;

    if( is_array($vars) && count($vars) >= 1 ) {
        extract($vars, EXTR_OVERWRITE);
    }

    if( use_cache === true ) {

        if( loop_model::$loopID !== false && loop_model::$loopI !== false ) {
            $cache_id = 'file-'.$sce_id.'--'.loop_model::$loopID.'-'.loop_model::$loopI;
        } else {
            $cache_id = 'file-'.$sce_id;
        }

        if ( ! $cache = $CI->cache->get($cache_id)) {
            $file = $CI->file_model->get_file($sce_id, 'sce_id');

            if( $file !== false ) {
                $CI->cache->save($cache_id, serialize($file), cache_ttl);
            }
        } else {
            $file = unserialize($cache);
        }

    } else {
        $file = $CI->file_model->get_file($sce_id, 'sce_id');
    }

    if( $file == false ) {
        $insert_id = $CI->file_model->create_file(array(
            'sce_id' => $sce_id,
            'path' => '',
            'text' => ''
        ));

        $file = array(
            'sce_id' => $sce_id,
            'path' => '',
            'text' => ''
        );

        if( $insert_id && is_numeric($insert_id) ) {
            $file['id'] = $insert_id;
        }
    }

    if( !empty($file['path']) ) {
        $return_file = $before;

        $return_file .= '<a href="'.upload_url($file['path']).'" title="'.html_escape($file['text']).'" class="'.$class.'" id="'.$id.'" target="'.$target.'" '.$custom_attributes_a.'>'.$file['text'].'</a>';

        $return_array = array(
            'src' => upload_url($file['path']),
            'text' => $file['text']
        );

        $return_file .= $after;
    } else {
        $return_array = false;
        $return_file = '';
    }

    if( is_logged_in() === true ) {
        echo '<span class="sce_editable_area sce_type_file">';

        echo $return_file;

        echo '&nbsp; <a href="'.site_url('/content/file/'.$file['id'].'?return_url='.urlencode(return_url())).'" class="sce_edit_button_small" data-lightbox-type="iframe"><i class="fa fa-pencil-square"></i></a>';

        echo '</span>';
    } else {


        if( $return == true ) {
            return $return_file;
        } elseif( $return == 'array' ) {
            return $return_array;
        } else {
            echo $return_file;
        }
    }
}

function sce_loopInit( $loop_id, $vars=array() )
{
    $CI =& get_instance();
    $CI->load->model('loop_model');

    if( is_array($vars) && count($vars) >= 1 ) {
        extract($vars, EXTR_OVERWRITE);
    }

    $loop = $CI->loop_model->get_loop($loop_id);

    if( $loop == false ) {
        $insert_id = $CI->loop_model->create_loop($loop_id);

        $loop = array(
            'id' => $insert_id,
            'loop_id' => $loop_id,
            'rows' => 1
        );
    }

    loop_model::$loopID = $loop_id;
    loop_model::$loopI = 1;
    loop_model::$loops = intval($loop['rows']);

    if( loop_model::$loops <= 0 ) {
        $CI->loop_model->add_row(loop_model::$loopID);
        loop_model::$loops = 1;
    }

    if( is_logged_in() === true ) {
        echo '<ol class="sce_loop_container" id="sce_loop_'.loop_model::$loopID.'-row_'.loop_model::$loopI.'">';
    }
}

function sce_loopStart()
{
    $CI =& get_instance();
    $CI->load->model('loop_model');

    if( is_logged_in() === true ) {
        echo '<li class="sce_loop--'.loop_model::$loopID.'--row_container" id="sce_loop_id--'.loop_model::$loopID.'---row--'.loop_model::$loopI.'" data-loop="'.loop_model::$loopID.'" data-row="'.loop_model::$loopI.'">';
    }
}

function sce_loopStop()
{
    $CI =& get_instance();
    $CI->load->model('loop_model');

    if( is_logged_in() === true ) {
        echo '<div class="sce_loop_header" id="sce_loop_header_'.loop_model::$loopID.'-row_'.loop_model::$loopI.'">';
        echo '<span class="sce_row_number"><span class="move"><i class="fa fa-arrows"></i></span> &nbsp; '.lang('row').': '.loop_model::$loopI.' / '.loop_model::$loops.'</span>';
        echo '<a href="#" class="sce_add_new_row" data-loop="'.loop_model::$loopID.'" data-row="'.loop_model::$loopI.'"><i class="fa fa-plus"></i><i class="fa fa-refresh fa-spin"></i><span class="sce_beside_icon_text"> &nbsp; '.lang('row_add').'</span></a>';
        echo '<a href="#" class="sce_delete_row" data-loop="'.loop_model::$loopID.'" data-row="'.loop_model::$loopI.'"><i class="fa fa-trash-o"></i><i class="fa fa-refresh fa-spin"></i><span class="sce_beside_icon_text"> &nbsp; '.lang('row_delete').'</span></a>';
        echo '</div>';

        echo '</li>';
    }

    if( loop_model::$loopI >= loop_model::$loops ) {

        if( is_logged_in() === true ) {
            echo '</ol>';
        }

        loop_model::$loopID = false;
        loop_model::$loopI = false;
        loop_model::$loops = false;
    } else {
        loop_model::$loopI++;
    }

}

function sce_loopController()
{
    $CI =& get_instance();
    $CI->load->model('loop_model');

    if( loop_model::$loopI <= loop_model::$loops && loop_model::$loopI !== false ) {
        return true;
    } else {
        return false;
    }
}

function return_url()
{
    $s = &$_SERVER;
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    $uri = $protocol . '://' . $host . $s['REQUEST_URI'];
    return $uri;
}
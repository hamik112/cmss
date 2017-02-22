<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 05/07/14
 * Time: 12:21
 */

function nav_active($current, $element)
{
    switch ($element) {
        case $current:
            echo 'active';
            break;
        default:
            echo '';
            break;
    }
}

function body_class($body_class)
{
    echo 'backend '.$body_class;
}

function type_helper($type)
{
    switch ($type) {
        case 'editor':
            echo lang('ct_editor_type_editor');
            break;
        case 'html':
            echo lang('ct_editor_type_html');
            break;
        case 'long':
            echo lang('ct_editor_type_long');
            break;
        case 'short':
            echo lang('ct_editor_type_short');
            break;
    }
}

function role_helper($role)
{
    switch ($role) {
        case 1:
            return lang('user_group_admin');
            break;
        case 2:
            return lang('user_group_user');
            break;
    }
}

function messages($messages)
{
    if( !is_array($messages) || count($messages) <= 0 )
        return;

    echo '<div class="panel '.$messages['type'].'">';
    foreach( $messages as $key => $msg )
    {
        if( is_numeric($key) ) {

            if( is_array($msg) ) {

                foreach( $msg as $key2 => $msg2 )
                {
                    if( is_numeric($key2) ) {
                        echo '<p>'.$msg2.'</p>';
                    }
                }

            } else {
                echo '<p>'.$msg.'</p>';
            }
        }
    }
    echo '</div>';
}

function upload_url($file)
{
    return base_url('/'.uploads_dir.'/'.$file);
}

function upload_path($file=false)
{
    if( $file !== false ) {
        return FCPATH.uploads_dir.DS.$file;
    } else {
        return FCPATH.uploads_dir.DS;
    }
}

function webspacefiles_size_helper($item, $check_dir=true)
{
    if( @is_dir($item['server_path']) && $check_dir )
        return;

    // KB
    $return = $item['size']/1024;
    $size = 'KB';

    // MB
    if( $return >= 1024 ) {
        $return = $return/1024;
        $size = 'MB';
    }

    // GB
    if( $return >= 1024 ) {
        $return = $return/1024;
        $size = 'GB';
    }

    return html_escape(number_format($return, 2, ',', '')).' '.$size;
}

function webspacefiles_totalsize_helper($items)
{
    $total = 0;

    foreach( $items as $item ) {
        $total = $total+$item['size'];
    }

    return webspacefiles_size_helper(array('size'=>$total));
}

function webspacefiles_file_helper($item, $uploads_dir=false, $backup=false)
{
    if( @is_dir($item['server_path']) ) {
        echo '<i class="fa fa-folder-open-o" style="width: 16px; display:inline-block"></i> <a href="'.site_url('files?open-dir='.$item['server_path']).'">'.html_escape($item['name']).'</a>';
    } else {
        $file_extension = explode('.', $item['name']);
        $file_extension = strtolower($file_extension[(count($file_extension)-1)]);
        if( in_array($file_extension, explode('|', editable_files)) ) {

            if( is_really_writable($item['server_path']) ) {
                echo '<i class="fa fa-file-code-o" style="width: 16px; display:inline-block"></i> <a href="'.site_url('files/edit-file?file='.$item['server_path']).'">'.html_escape($item['name']).'</a>';
            } else {
                echo '<i class="fa fa-file-code-o" style="width: 16px; display:inline-block"></i> <a class="red" title="'.lang('files_file_nw').'">'.html_escape($item['name']).'</a>';
            }

        } else {
            if( $uploads_dir == true ) {
                if( in_array($file_extension, explode('|', allowed_images)) ) {
                    $class = 'nivo-lightbox';
                } else {
                    $class = '';
                }

                echo '<i class="fa fa-file-o" style="width: 16px; display:inline-block"></i> <a href="'.base_url(uploads_dir.'/'.$item['name']).'" title="'.html_escape($item['name']).'" class="'.$class.'">'.html_escape($item['name']).'</a>';

            } else if ( $backup == true ) {
                echo '<i class="fa fa-file-zip-o" style="width: 16px; display:inline-block"></i> <a href="'.site_url('backup?action=download&file='.$item['name']).'" target="_blank">'.html_escape($item['name']).'</a>';
            } else {
                echo '<i class="fa fa-file-o" style="width: 16px; display:inline-block"></i> '.html_escape($item['name']);
            }
        }

    }
}

function webspacefiles_file_options($item, $backup=false)
{
    if( $backup === true ) {
        $item['server_path'] = str_replace($item['name'], '', $item['server_path']);
        echo '<a href="'.site_url('backup?del='.$item['name']).'" class="red files_del_link" data-tooltip class="has-tip" title="'.lang('files_file_del').'"><i class="fa fa-trash-o"></i></a>';
    } elseif( @!is_dir($item['server_path']) ) {
        $file_extension = explode('.', $item['name']);
        $file_extension = strtolower($file_extension[(count($file_extension)-1)]);

        if( is_really_writable($item['server_path']) && in_array($file_extension, explode('|', editable_files)) ) {
            echo '<a href="'.site_url('files/edit-file?file='.$item['server_path']).'" data-tooltip class="has-tip" title="'.lang('files_file_edit').'"><i class="fa fa-pencil-square-o"></i></a> &nbsp;';

            $item['server_path'] = str_replace($item['name'], '', $item['server_path']);
            echo '<a href="'.site_url('files?open-dir='.$item['server_path'].'&del='.$item['name']).'" class="red files_del_link" data-tooltip class="has-tip" title="'.lang('files_file_del').'"><i class="fa fa-trash-o"></i></a>';
        } elseif( is_really_writable($item['server_path']) ) {
            $item['server_path'] = str_replace($item['name'], '', $item['server_path']);
            echo '<a href="'.site_url('files?open-dir='.$item['server_path'].'&del='.$item['name']).'" class="red files_del_link" data-tooltip class="has-tip" title="'.lang('files_file_del').'"><i class="fa fa-trash-o"></i></a>';
        }
    } elseif( @is_dir($item['server_path']) ) {
        echo '<a href="'.site_url('files?open-dir='.$item['relative_path'].'&del_dir='.$item['name']).'" class="red files_del_link" data-tooltip class="has-tip" title="'.lang('files_file_del').'"><i class="fa fa-trash-o"></i></a>';
    }
}

function webspacefiles_up_link($dir)
{

    if( $dir == DS )
        return;

    $dir = rtrim($dir, DS);
    $current_folder = explode(DS, $dir);
    $current_folder = $current_folder[(count($current_folder)-1)];
    $up_dir = str_replace($current_folder, '', $dir);
    $up_dir = trim($up_dir);

    if( empty($up_dir) ) {
        $up_dir = DS;
    }

    if( @is_dir($up_dir) && !empty($up_dir) ) {
    ?>
        <tr>
            <td><a href="<?php echo site_url('files?open-dir=').$up_dir ?>"><i class="fa fa-folder" style="width: 16px; display:inline-block"></i> ..</a></td>
            <td class="text-right"></td>
            <td class="text-right"></td>
        </tr>
    <?php
    }
}

function get_setting($key, $default=false)
{
    $CI =& get_instance();
    $CI->load->model('simplece_model');
    $setting = $CI->simplece_model->get_setting($key, $default);

    if( is_array($setting) ) {
        return $setting['value'];
    } else {
        return $setting;
    }

}

function get_upper_dir_link($url)
{
    $url_info = parse_url($url);

    if( strstr($url_info['path'], 'index.php') ) {
        $explode = explode('index.php', $url_info['path']);
        $url_info['path'] = $explode[0];
    }

    $url_info['path'] = rtrim($url_info['path'], '/');

    $dir_list = explode('/', $url_info['path']);
    $count = count($dir_list)-2;

    if( $count <= 0 ) {
        return $url_info['scheme'].'://'.$url_info['host'];
    } else {
        $dirs = '';

        for ($i = 1; $i <= $count; $i++) {
            $dirs .= '/'.$dir_list[$i];
        }

        return $url_info['scheme'].'://'.$url_info['host'].$dirs;
    }
}

function last_update_check_info()
{
    $last_update_check = get_setting('last_update_check');

    if( !empty($last_update_check) && is_numeric($last_update_check) ) {
        return date(date_format, $last_update_check);
    } else {
        return 'N/A';
    }
}
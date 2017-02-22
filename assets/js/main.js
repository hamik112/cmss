/**
 * Created by pascalbajorat on 10/07/14.
 */

jQuery(document).ready(function(){

    if( jQuery('.dashboard-column').length >= 1 ) {
        window.setTimeout(function(){
            jQuery('.dashboard-column').equalHeights();
        }, 1500);
    }

    jQuery('a.nivo-lightbox').nivoLightbox();

    /**
     * Colorpicker
     */
    if( jQuery('#colorpicker1').length >= 1 ) {
        jQuery('#colorpicker1, #colorpicker2').hide();

        jQuery('.open-colorpicker').on('focus', function(){
            colorpicker = jQuery(this).attr('data-colorpicker');
            jQuery(colorpicker).slideDown('slow');
        }).on('blur', function(){
            colorpicker = jQuery(this).attr('data-colorpicker');
            jQuery(colorpicker).slideUp('slow');
        });

        jQuery('#colorpicker1').farbtastic('#fe_color_1');
        jQuery('#colorpicker2').farbtastic('#fe_color_2');

        jQuery('.color-reset').on('click', function(){
            color = jQuery(this).attr('data-color');
            field = jQuery(this).attr('data-field');

            jQuery(field).css('background-color', color).val(color);

            return false;
        });
    }

    jQuery('.files_del_link').on('click', function(){
        cnf = confirm('Are you sure that you want delete this file?');

        if( cnf ) {
            return true;
        } else {
            return false;
        }
    });

    jQuery('.confirm-button').on('click', function(){
        question = jQuery(this).attr('data-confirm');

        cnf = confirm(question);

        if( cnf ) {
            return true;
        } else {
            return false;
        }
    });

    /**
     * Update-Check
     */
    update_check = function() {
        jQuery.getJSON(sce_ajax_url+'/update-check', function(data){
            jQuery('#update-check-message').html(data.message);

            if( data.status == 'update' ) {
                new_txt = jQuery('#system-info-update-btn').attr('data-update');
                jQuery('#system-info-update-btn').text(new_txt).addClass('green');
            }

            jQuery('.dashboard-column').css('height', '');
            jQuery('.dashboard-column').equalHeights();
        });
    };

    if( jQuery('#update-check-message').length >= 1 ) {
        update_check();
    }

    if( jQuery('.system-info-tab').length >= 1 ) {
        jQuery.getJSON(sce_ajax_url+'/update-check', function(data){

            if( data.status == 'update' ) {
                jQuery('.fill-update-version').text('v.'+data.version);
                jQuery('.update-check-message').html(data.message+' '+data.changelog_info);
                jQuery('#update-panel').removeClass('hide').show('slow');
            } else if ( data.status == 'uptodate' ) {
                currentVersion = jQuery('.current-version').text();
                jQuery('.fill-update-version').text('v.'+currentVersion);
            }

        });

        jQuery('#install-update').on('click', function() {
            jQuery('#update-status').html('<i class="fa fa-refresh fa-spin" style="font-size: 48px"></i><br />&nbsp; <strong>Please wait...</strong>').addClass('text-center');

            jQuery.ajaxSetup({
                timeout: 60000
            });

            jQuery.getJSON(sce_ajax_url+'/install-update', function(data){
                if( data.status == 'success' ) {
                    jQuery('#update-panel').addClass('success').html('<p>'+data.message+'</p>');
                } else {
                    jQuery('#update-panel').addClass('error').html('<p>'+data.message+'</p>');
                }
            });

            return false;
        });
    }

    /**
     * Text-Element-Generator
     */
    jQuery('#text-element-output').hide();

    jQuery('#generate-text').on('click', function(){
        textGenerator();
        return false;
    });

    jQuery('#text-generator input, #text-generator select').on('change', function(){
        textGenerator();
    });

    textGenerator = function(){
        id = jQuery('#text_sce_id').val();
        type = jQuery('#text_type').val();
        mode = jQuery('#text_mode').val();
        before = jQuery('#text_before').val();
        after = jQuery('#text_after').val();

        return_mode = jQuery('#text_return').val();

        options = '';

        if( id == '' ) {
            id = 1;
        }

        if( mode != 'modal' || return_mode != 'echo' || before != '' || after != '' ) {
            options = ', array(';

            if( mode != 'modal' ) {
                options = options+'\'mode\' => \''+mode+'\', ';
            }

            if( return_mode != 'echo' ) {
                options = options+'\'return\' => true, ';
            }

            if( before != '' ) {
                before = before.replace('<', '&lt;');
                before = before.replace('>', '&gt;');
                options = options+'\'before\' => \''+before+'\', ';
            }

            if( after != '' ) {
                after = after.replace('<', '&lt;');
                after = after.replace('>', '&gt;');
                options = options+'\'after\' => \''+after+'\'';
            }

            options = jQuery.trim(options);
            options = options.replace(/,+$/,'');

            options = options+')';
        }

        output = '&lt;?php sce_editor('+id+', \''+type+'\''+options+'); ?&gt;';

        jQuery('#text-element-output').html('<code>'+output+'</code>').slideDown('slow');
    };

    /**
     * Image-Element-Generator
     */
    jQuery('#image-element-output').hide();

    jQuery('#generate-image').on('click', function(){
        imageGenerator();
        return false;
    });

    jQuery('#image-generator input, #image-generator select').on('change', function(){
        imageGenerator();
    });

    imageGenerator = function(){
        id = jQuery('#image_sce_id').val();
        target = jQuery('#image_target').val();
        before = jQuery('#image_before').val();
        after = jQuery('#image_after').val();

        thumb_width = jQuery('#image_thumb_width').val();
        thumb_height = jQuery('#image_thumb_height').val();

        return_mode = jQuery('#image_return').val();

        options = '';

        if( id == '' ) {
            id = 1;
        }

        if( return_mode != 'echo' || target != 'self' || before != '' || after != '' || thumb_width != '' || thumb_height != '' ) {
            options = ', array(';

            if( target != 'self' ) {
                options = options+'\'target\' => \'_'+target+'\', ';
            }

            if( thumb_width != '' ) {
                options = options+'\'thumb_width\' => '+thumb_width+', ';
            }

            if( thumb_height != '' ) {
                options = options+'\'thumb_height\' => '+thumb_height+', ';
            }

            if( before != '' ) {
                before = before.replace('<', '&lt;');
                before = before.replace('>', '&gt;');
                options = options+'\'before\' => \''+before+'\', ';
            }

            if( after != '' ) {
                after = after.replace('<', '&lt;');
                after = after.replace('>', '&gt;');
                options = options+'\'after\' => \''+after+'\', ';
            }

            if( return_mode == 'array' ) {
                options = options+'\'return\' => \'array\', ';
            } else if( return_mode != 'echo' ) {
                options = options+'\'return\' => true, ';
            }

            options = jQuery.trim(options);
            options = options.replace(/,+$/,'');

            options = options+')';
        }

        output = '&lt;?php sce_image('+id+options+'); ?&gt;';

        jQuery('#image-element-output').html('<code>'+output+'</code>').slideDown('slow');
    };

    /**
     * File-Element-Generator
     */
    jQuery('#file-element-output').hide();

    jQuery('#generate-file').on('click', function(){
        fileGenerator();
        return false;
    });

    jQuery('#file-generator input, #file-generator select').on('change', function(){
        fileGenerator();
    });

    fileGenerator = function(){
        id = jQuery('#file_sce_id').val();
        target = jQuery('#file_target').val();
        before = jQuery('#file_before').val();
        after = jQuery('#file_after').val();

        return_mode = jQuery('#file_return').val();

        options = '';

        if( id == '' ) {
            id = 1;
        }

        if( return_mode != 'echo' || target != 'blank' || before != '' || after != '' ) {
            options = ', array(';

            if( target != 'blank' ) {
                options = options+'\'target\' => \'_'+target+'\', ';
            }

            if( before != '' ) {
                before = before.replace('<', '&lt;');
                before = before.replace('>', '&gt;');
                options = options+'\'before\' => \''+before+'\', ';
            }

            if( after != '' ) {
                after = after.replace('<', '&lt;');
                after = after.replace('>', '&gt;');
                options = options+'\'after\' => \''+after+'\', ';
            }

            if( return_mode == 'array' ) {
                options = options+'\'return\' => \'array\', ';
            } else if( return_mode != 'echo' ) {
                options = options+'\'return\' => true, ';
            }

            options = jQuery.trim(options);
            options = options.replace(/,+$/,'');

            options = options+')';
        }

        output = '&lt;?php sce_file('+id+options+'); ?&gt;';

        jQuery('#file-element-output').html('<code>'+output+'</code>').slideDown('slow');
    };
});
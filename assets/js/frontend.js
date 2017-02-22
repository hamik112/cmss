/**
 * Created by pascalbajorat on 24/07/14.
 */
var sce_connection_error = 'Please check your internet connection!';
var sce_unknown_error = 'Sorry, there was an unknown error';

jQuery(document).ready(function(){

    if( sce_disable_lightbox != 'yes' ) {
        jQuery('.sce-topbar nav a.sce-lightbox, .sce_edit_button, .sce_edit_button_small').nivoLightbox({
            beforeHideLightbox: function(){
                window.location.reload();
            }
        });
    } else {
        //jQuery('.sce-topbar nav a.sce-lightbox, .sce_edit_button, .sce_edit_button_small').attr('target', '_blank');
    }

    var sortableGroup = jQuery('ol.sce_loop_container').sortable({
        handle: '.sce_row_number',
        onDrop: function (item, container, _super) {

            var data = sortableGroup.sortable('serialize').get();
            var jsonString = JSON.stringify(data, null, ' ');

            loop_id = jQuery(item).attr('data-loop');
            loop_row = jQuery(item).attr('data-row');

            //alert(jsonString);

            sortableGroup.sortable('disable');
            jQuery.post(sce_ajax_url+'/move-row/'+loop_id, {'loop_id': loop_id, 'data': jsonString}, function(data){

                //alert(data);

                if( data.return == 'true' ) {
                    window.location.reload();

                    jQuery('#sce_loop_'+loop_id+'-row_1 .sce_loop--'+loop_id+'--row_container').each(function(i){
                        jQuery(this).attr('data-row', i+1);
                        jQuery(this).attr('id', 'sce_loop_id--'+loop_id+'---row--'+(i+1));
                    });

                    //sortableGroup.sortable('enable');
                    //sortableGroup.sortable('refresh');
                } else {
                    alert(sce_unknown_error);
                    window.location.reload();
                }

            }).fail(function(){ alert(sce_connection_error); });

            _super(item, container)
        }
    });

    jQuery('.sce_image_lightbox').nivoLightbox();

    jQuery('.sce_add_new_row').on('click', function(){

        jQuery('.fa', this).hide();
        jQuery('.fa-spin', this).show();

        loop_id = jQuery(this).attr('data-loop');
        row = jQuery(this).attr('data-row');

        jQuery.post(sce_ajax_url+'/add-row/'+loop_id+'/'+row, {'loop_id': loop_id, 'row': row}, function(data){

            if( data.return == 'true' ) {
                window.location.reload();
            } else {
                alert(sce_unknown_error);
                window.location.reload();
            }

        }).fail(function(){ alert(sce_connection_error); });

        return false;
    });

    jQuery('.sce_delete_row').on('click', function(){

        jQuery('.fa', this).hide();
        jQuery('.fa-spin', this).show();

        loop_id = jQuery(this).attr('data-loop');
        row = jQuery(this).attr('data-row');

        jQuery.post(sce_ajax_url+'/del-row/'+loop_id+'/'+row, {'loop_id': loop_id, 'row': row}, function(data){

            if( data.return == 'true' ) {
                window.location.reload();
            } else {
                alert(sce_unknown_error);
                window.location.reload();
            }

        }).fail(function(){ alert(sce_connection_error); });

        return false;
    });
});

CKEDITOR.on( 'instanceCreated', function( event ) {
    var editor = event.editor,
        element = editor.element;

    var sce_id = jQuery(element).attr('data-id');
    var sce_loop = jQuery(element).attr('data-loop');
    var sce_row = jQuery(element).attr('data-row');
    var sce_type = jQuery(element).attr('data-type');

    editor.on( 'configLoaded', function() {

        editor.config.filebrowserImageUploadUrl = sce_filebrowserImageUploadUrl;
        editor.config.floatSpaceDockedOffsetY = 50;
        editor.config.language = sce_lang;

        if( sce_type == 'short' || sce_type == 'long' ) {
            editor.config.removePlugins = 'toolbar';
            editor.config.enterMode = CKEDITOR.ENTER_BR;
            editor.config.shiftEnterMode = CKEDITOR.ENTER_BR;
            editor.config.autoParagraph = false;
        }

        if( sce_editor_mode == 'Full' ) {
            editor.config.toolbarGroups = [
                { name: 'document',    groups: [ 'mode', 'document', 'doctools' ]},
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                { name: 'editing',     groups: [ 'find', 'selection' ] },
                { name: 'forms' },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph',   groups: [ 'list', 'blocks', 'align' ] },
                { name: 'links' },
                { name: 'insert' },
                '/',
                { name: 'styles' },
                { name: 'colors' },
                { name: 'tools' },
                { name: 'others' }
            ];
        } else if( sce_editor_mode == 'Basic' ) {
            editor.config.toolbarGroups = [
                { name: 'document',    groups: [ 'mode' ]},
                { name: 'basicstyles', groups: [ 'basicstyles'] },
                { name: 'paragraph',   groups: [ 'list', 'align' ] },
                { name: 'links' },
                { name: 'tools' }
            ];
        } else {
            editor.config.toolbarGroups = [
                { name: 'document',    groups: ['mode']},
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                { name: 'links' },
                { name: 'insert' },
                { name: 'tools' },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles'] },
                { name: 'paragraph',   groups: [ 'list', 'align' ] },
                { name: 'styles' },
                { name: 'colors' },
                { name: 'others' }
            ];
        }
    });

    editor.on( 'instanceReady', function( event )
    {
        if (sce_code_style == 'html5') {
            event.editor.dataProcessor.writer.selfClosingEnd = '>';
        } else {
            event.editor.dataProcessor.writer.selfClosingEnd = ' />';
        }
    });

    editor.on( 'blur', function() {
        var data = event.editor.getData();

        var request = jQuery.ajax({
            url: sce_ajax_url+'/update-text/'+sce_id+'/',
            type: "POST",
            data: {
                sce_id : sce_id,
                sce_loop : sce_loop,
                sce_row : sce_row,
                text : data,
                type : sce_type
            },
            dataType: "html"
        });

    });
});

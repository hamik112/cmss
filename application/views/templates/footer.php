<footer class="copyright">
    <?php
    $copyright = get_setting('copyright');
    if( !empty($copyright) && $copyright != false ) {
        echo html_escape($copyright);
    } else {
        echo copyright;
    }
    ?>
</footer>
<script>
    var sce_ajax_url = '<?php echo site_url('ajax') ?>';
</script>
<script src="<?php echo base_url('assets/js/vendor/jquery.js') ?>"></script>
<script src="<?php echo base_url('assets/js/foundation.min.js') ?>"></script>
<!--script src="<?php echo base_url('assets/nivo-lightbox/nivo-lightbox.min.js') ?>"></script-->
<script src="<?php echo base_url('assets/js/plugins.min.js') ?>"></script>
<?php if( $farbtastic ): ?>
<script src="<?php echo base_url('assets/farbtastic/farbtastic.min.js') ?>"></script>
<?php endif; ?>
<script>
    jQuery(document).foundation();
</script>
<script src="<?php echo base_url('assets/js/main.js') ?>"></script>
<?php if( $ckeditor === true ): ?>
<script src="<?php echo base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo base_url('assets/ckeditor/adapters/jquery.js') ?>"></script>
<script>
    jQuery('#text').ckeditor({
        skin: 'moono-dark',
        height: 400,
        <?php
        if( language == 'german' ) {
        echo 'language: \'de\',';
        } else {
        echo 'language: \'en\',';
        }
        ?>
        filebrowserImageUploadUrl: '<?php echo site_url('ajax/cke-upload'); ?>',
        <?php if( get_setting('editor_mode') == 'Full' ): ?>
        toolbarGroups: [
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
        ]
        <?php elseif( get_setting('editor_mode') == 'Basic' ): ?>
        toolbarGroups: [
            { name: 'document',    groups: [ 'mode' ]},
            { name: 'basicstyles', groups: [ 'basicstyles'] },
            { name: 'paragraph',   groups: [ 'list', 'align' ] },
            { name: 'links' },
            { name: 'tools' }
        ]
        <?php else: ?>
        toolbarGroups: [
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
        ]
        <?php endif; ?>
    });

    CKEDITOR.on( 'instanceReady', function( event )
    {
        <?php if( get_setting('code_style') == 'html5' ): ?>
        event.editor.dataProcessor.writer.selfClosingEnd = '>';
        <?php else: ?>
        event.editor.dataProcessor.writer.selfClosingEnd = ' />';
        <?php endif; ?>
    });
</script>
<?php endif; ?>

<?php if( $aceeditor === true && $editor_mode != false ): ?>
<script src="<?php echo base_url('assets/aceeditor/ace.js') ?>"></script>
<script src="<?php echo base_url('assets/aceeditor/ext-language_tools.js') ?>"></script>
<script src="<?php echo base_url('assets/aceeditor/ext-statusbar.js') ?>"></script>
<script>
    ace.require('ace/ext/language_tools');
    ace.require('ace/ext/statusbar');

    var editor = ace.edit("ace-editor");
    editor.setTheme("ace/theme/github");

    StatusBar = ace.require('ace/ext/statusbar').StatusBar;
    statusBar = new StatusBar(editor, document.getElementById('statusBar') );

    //editor.setTheme('ace/theme/chrome');
    editor.setTheme("ace/theme/github");
    editor.setShowPrintMargin(false);
    editor.getSession().setMode('ace/mode/<?php echo $editor_mode; ?>');
    editor.getSession().setUseWrapMode(true);
    editor.getSession().setWrapLimitRange('free');
    editor.setWrapBehavioursEnabled(true);
    editor.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true
    });

    editor.on('change', function(e){
        content = editor.getValue();
        jQuery('#file_content, #text').val( content );
    });
</script>
<?php endif; ?>
</body>
</html>
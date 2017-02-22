<div class="wrapper">
    <div class="row">
        <div class="small-12 columns">
            <div class="white-wrapper">
                <?php messages($messages); ?>

                <?php
                if( $file_status === true ):
                ?>
                <form action="<?php echo site_url('files/edit-file?file='.$file) ?>" method="post">
                    <p><i class="fa fa-file-code-o"></i> <?php echo html_escape($file) ?></p>


                    <div id="ace-editor"><?php echo html_escape($file_content) ?></div>
                    <div id="statusBar" class="text-right"></div>

                    <div style="display: none;">
                        <textarea name="file_content" id="file_content"></textarea>
                    </div>

                    <div class="clearfix">
                        <a href="<?php echo site_url('files?open-dir='.$folder_path); ?>" class="button left no-margin top-margin grey"><i class="fa fa-caret-left"></i> <?php echo lang('back') ?></a>
                        <button type="submit" name="save" id="save" value="save" class="button right no-margin top-margin"><i class="fa fa-floppy-o"></i> <?php echo lang('save') ?></button>
                    </div>
                </form>
                <?php else: ?>
                <div class="panel no-content">
                    <h5><?php echo lang('files_error2_h') ?></h5>
                    <p><?php echo lang('files_error2_t') ?></p>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
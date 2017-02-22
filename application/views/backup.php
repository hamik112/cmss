<div class="wrapper">
    <div class="row">
        <div class="small-12 columns">
            <div class="white-wrapper">

                <h3><?php echo lang('nav_backup') ?></h3>

                <?php messages($messages); ?>

                <p><?php echo lang('backup_desc') ?></p>

                <?php
                if( !function_exists('zip_open') || !function_exists('zip_read') ):
                ?>
                    <div class="panel error">
                        <p><?php echo lang('backup_driver_error_zip') ?></p>
                    </div>
                <?php
                endif;
                ?>

                <?php //if( strtolower($this->db->dbdriver) == 'mysql' ): ?>

                <p class="text-center" style="padding-top: 40px">
                    <a href="<?php echo site_url('backup?action=do_backup') ?>" class="button"><i class="fa fa-database"></i> &nbsp; <?php echo lang('backup_btn_backup') ?></a> &nbsp;
                    <a href="<?php echo site_url('backup?action=do_optimization') ?>" class="button"><i class="fa fa-cogs"></i> &nbsp; <?php echo lang('backup_btn_optimize') ?></a>
                </p>

                <?php /*else: ?>

                <div class="panel error">
                    <p><?php echo lang('backup_driver_error') ?></p>
                </div>

                <?php endif; */ ?>

                <?php if( count($backup_files) > 0 ): ?>
                    <p><i class="fa fa-file-code-o"></i> <?php echo lang('backup_path') ?>: <?php echo $backup_path; ?></p>

                    <table class="content-table foundation-table">
                        <thead>
                        <tr>
                            <th style="width: 75%"><?php echo lang('files_name') ?></th>
                            <th class="text-right"><?php echo lang('files_size') ?></th>
                            <th class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach( $backup_files as $item ) {

                            if( $item['name'] == 'index.html' ) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td><?php webspacefiles_file_helper($item, false, true) ?></td>
                                <td class="text-right"><?php echo webspacefiles_size_helper($item) ?></td>
                                <td class="text-center" style="font-size: 1.2em;"><?php webspacefiles_file_options($item, true) ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td class="text-right" style="font-weight: bold;"><?php echo webspacefiles_totalsize_helper($backup_files) ?></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                <?php endif; ?>

                <h3 style="padding-top: 30px"><?php echo lang('cache_h') ?></h3>
                <p><?php echo lang('cache_desc') ?></p>

                <p><strong><?php echo lang('cache_info') ?>:<br /></strong>
                    <?php if( @is_dir($text_cache) ): ?>
                    <i class="fa fa-cube"></i> <?php echo lang('cache_general_cache') ?>: <?php echo webspacefiles_totalsize_helper($text_cache_info) ?> <small>(<?php echo $text_cache; ?>)</small><br />
                    <?php endif; ?>

                    <?php if( @is_dir($image_cache) ): ?>
                    <i class="fa fa-file-image-o"></i> <?php echo lang('cache_image_cache') ?>: <?php echo webspacefiles_totalsize_helper($image_cache_info) ?> <small>(<?php echo $image_cache; ?>)</small><br />
                    <?php endif; ?>

                    <?php if( @is_dir($update_cache) ): ?>
                    <i class="fa fa-cloud-download"></i> <?php echo lang('cache_update_cache') ?>: <?php echo webspacefiles_totalsize_helper($update_cache_info) ?> <small>(<?php echo $update_cache; ?>)</small></p>
                    <?php endif; ?>

                <p class="text-center" style="padding-top: 40px">
                    <a href="<?php echo site_url('backup?action=clean_caches') ?>" class="button no-margin"><i class="fa fa-cube"></i> &nbsp; <?php echo lang('cache_clean_btn') ?></a>
                </p>
            </div>
        </div>
    </div>
</div>
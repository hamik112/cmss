<div class="wrapper">
    <div class="row">
        <ul class="tabs" data-tab>
            <li class="tab-title <?php echo ((empty($_GET['open-dir']))?'active':'') ?>"><a href="#panel-1"><i class="fa fa-file-image-o"></i> <?php echo lang('files_tab2') ?></a></li>
            <li class="tab-title <?php echo ((!empty($_GET['open-dir']))?'active':'') ?>"><a href="#panel-2"><i class="fa fa-file-text-o"></i> <?php echo lang('files_tab1') ?></a></li>
        </ul>
        <div class="tabs-content">
            <div class="content <?php echo ((empty($_GET['open-dir']))?'active':'') ?>" id="panel-1">
                <form action="<?php echo site_url('/files'); ?>" method="get" class="clearfix no-margin">
                    <div class="row collapse">
                        <div class="small-10 medium-11 columns">
                            <input type="text" name="open-dir" id="open-dir" value="<?php echo html_escape($uploads_dir); ?>" />
                        </div>
                        <div class="small-2 medium-1 columns">
                            <button type="submit" class="button postfix">GO</button>
                        </div>
                    </div>
                </form>

                <?php if( $webspace_files && is_array($webspace_files) ): ?>
                    <table class="content-table foundation-table">
                        <thead>
                        <tr>
                            <th style="width: 75%"><?php echo lang('files_name') ?></th>
                            <th class="text-right"><?php echo lang('files_size') ?></th>
                            <th class="text-center" style="width: 60px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach( $uploads as $item ) {

                            if( $item['name'] == 'index.html' )
                                continue;
                            ?>
                            <tr>
                                <td><?php webspacefiles_file_helper($item, true) ?></td>
                                <td class="text-right"><?php echo webspacefiles_size_helper($item) ?></td>
                                <td class="text-center" style="font-size: 1.2em;"><?php webspacefiles_file_options($item) ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                            <tr>
                                <td></td>
                                <td class="text-right" style="font-weight: bold;"><?php echo webspacefiles_totalsize_helper($uploads) ?></td>
                                <td class="text-center"></td>
                            </tr>
                        </tbody>
                    </table>

                    <hr />

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <form action="<?php echo site_url('/files?open-dir='.$uploads_dir); ?>" method="post" class="no-margin">
                                <div class="row collapse">
                                    <div class="small-4 medium-7 columns">
                                        <input type="text" name="name" id="name" placeholder="<?php echo lang('files_create_file_or_folder') ?>" />
                                    </div>
                                    <div class="small-8 medium-5 columns">
                                        <ul class="button-group">
                                            <li><button type="submit" name="folder" id="folder" value="folder" class="button tiny input-height"><?php echo lang('files_folder') ?></button></li>
                                            <li><button type="submit" name="file" id="file" value="file" class="button tiny input-height"><?php echo lang('files_file') ?></button></li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <form action="<?php echo site_url('/files?open-dir='.$uploads_dir); ?>" enctype="multipart/form-data" method="post" class="right no-margin">

                                <div class="row collapse">
                                    <div class="small-8 medium-10 columns">
                                        <label for="upload"><?php echo lang('files_add_file') ?>:
                                            <input type="file" id="upload" name="upload" size="20" />
                                        </label>
                                    </div>
                                    <div class="small-4 medium-2 columns">
                                        <button type="submit" class="button postfix" style="font-size: 1.4rem !important"><i class="fa fa-cloud-upload"></i></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="panel no-content">
                        <h5><?php echo lang('files_error1_h') ?></h5>
                        <p><?php echo lang('files_error1_t') ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="content <?php echo ((!empty($_GET['open-dir']))?'active':'') ?>" id="panel-2">

                <form action="<?php echo site_url('/files'); ?>" method="get" class="clearfix no-margin">
                    <div class="row collapse">
                        <div class="small-10 medium-11 columns">
                            <input type="text" name="open-dir" id="open-dir" value="<?php echo html_escape($dir); ?>" />
                        </div>
                        <div class="small-2 medium-1 columns">
                            <button type="submit" class="button postfix">GO</button>
                        </div>
                    </div>
                </form>

                <?php if( /*$webspace_files &&*/ is_array($webspace_files) ): ?>
                    <table class="content-table foundation-table">
                        <thead>
                        <tr>
                            <th style="width: 75%"><?php echo lang('files_name') ?></th>
                            <th class="text-right"><?php echo lang('files_size') ?></th>
                            <th class="text-center" style="width: 60px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        webspacefiles_up_link($dir);

                        foreach( $webspace_files as $item ) {
                            ?>
                            <tr>
                                <td><?php webspacefiles_file_helper($item) ?></td>
                                <td class="text-right"><?php echo webspacefiles_size_helper($item) ?></td>
                                <td class="text-right" style="font-size: 1.2em;"><?php webspacefiles_file_options($item) ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td class="text-right" style="font-weight: bold;"><?php echo webspacefiles_totalsize_helper($webspace_files) ?></td>
                            <td class="text-center"></td>
                        </tr>
                        </tbody>
                    </table>

                    <hr />

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <form action="<?php echo site_url('/files?open-dir='.$dir); ?>" method="post" class="no-margin">
                                <div class="row collapse">
                                    <div class="small-4 medium-7 columns">
                                        <input type="text" name="name" id="name" placeholder="<?php echo lang('files_create_file_or_folder') ?>" />
                                    </div>
                                    <div class="small-8 medium-5 columns">
                                        <ul class="button-group">
                                            <li><button type="submit" name="folder" id="folder" value="folder" class="button tiny input-height"><?php echo lang('files_folder') ?></button></li>
                                            <li><button type="submit" name="file" id="file" value="file" class="button tiny input-height"><?php echo lang('files_file') ?></button></li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <form action="<?php echo site_url('/files?open-dir='.$dir); ?>" enctype="multipart/form-data" method="post" class="right no-margin">

                                <div class="row collapse">
                                    <div class="small-8 medium-10 columns">
                                        <label for="upload"><?php echo lang('files_add_file') ?>:
                                            <input type="file" id="upload" name="upload" size="20" />
                                        </label>
                                    </div>
                                    <div class="small-4 medium-2 columns">
                                        <button type="submit" class="button postfix" style="font-size: 1.4rem !important"><i class="fa fa-cloud-upload"></i></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="panel no-content">
                        <h5><?php echo lang('files_error1_h') ?></h5>
                        <p><?php echo lang('files_error1_t') ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="row">
        <div class="small-12 columns">
            <div class="white-wrapper">

                <?php
                $return_url = $this->input->get('return_url');
                messages($messages); ?>

                <form action="<?php echo site_url('/content/file/'.$file['id'].((!empty($return_url))?'?return_url='.urlencode($return_url):'')); ?>" enctype="multipart/form-data" method="post" class="clearfix no-margin">

                    <input type="hidden" name="id" id="id" value="<?php echo $file['id']; ?>" />

                    <div class="row">
                        <div class="small-10 columns">
                            <label for="text"><?php echo lang('ct_lnk_text') ?>
                                <input type="text" name="text" id="text" placeholder="<?php echo lang('ct_lnk_text') ?>" value="<?php echo $file['text'] ?>" />
                            </label>
                        </div>
                        <div class="small-2 columns">
                            <label for="sce_id"><?php echo lang('ct_id') ?>
                                <input type="text" name="sce_id" id="sce_id" placeholder="<?php echo lang('ct_id') ?>" value="<?php echo $file['sce_id'] ?>" />
                            </label>
                        </div>
                    </div>

                    <?php if( !empty($file['path']) ): ?>
                    <div class="panel">
                        <?php $file_info = @get_file_info(upload_path($file['path'])); ?>
                        <p><?php echo lang('ct_lnk_file') ?>: <a href="<?php echo upload_url($file['path']) ?>" target="_blank"><?php echo upload_url($file['path']) ?></a><br />
                        <?php echo lang('ct_lnk_size') ?>: <?php echo (($file_info['size'])?number_format($file_info['size']/1024/1024, '2', ',', '').' MB':'N/A') ?><br />
                        <?php echo lang('ct_lnk_date') ?>: <?php echo (($file_info['date'])?date('m/d/Y - g:i a', $file_info['date']):'N/A') ?><br /><br />

                        <a href="<?php echo current_url().'?delete=true'.((!empty($return_url))?'&return_url='.urlencode($return_url):''); ?>"><i class="fa fa-trash-o"></i> <?php echo lang('ct_file_delete') ?></a></p>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="small-6 columns">
                            <label for="upload"><?php echo lang('ct_file_upload') ?>:
                                <input type="file" id="upload" name="upload" size="20" />
                            </label>
                        </div>
                        <div class="small-6 columns text-right">

                        </div>
                    </div>

                    <div class="clearfix">
                        <?php
                        if( !empty($return_url) ):
                            ?>
                            <a href="<?php echo $return_url; ?>" class="button left no-margin top-margin grey" target="_parent"><i class="fa fa-caret-left"></i> <?php echo lang('back') ?></a>
                        <?php else: ?>
                            <a href="<?php echo site_url('/content/?active=files'); ?>" class="button left no-margin top-margin grey"><i class="fa fa-caret-left"></i> <?php echo lang('back') ?></a>
                        <?php endif; ?>

                        <ul class="button-group right top-margin">
                            <li><a href="<?php echo site_url('/content?active=files&del='.$file['id']) ?>" class="button no-margin del confirm-button" data-confirm="<?php echo lang('delete') ?>?"><i class="fa fa-trash-o"></i></a></li>
                            <li><button type="submit" name="save" id="save" value="save" class="button no-margin"><i class="fa fa-floppy-o"></i> <?php echo lang('save') ?></button></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
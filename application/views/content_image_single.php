<div class="wrapper">
    <div class="row">
        <div class="small-12 columns">
            <div class="white-wrapper">

                <?php
                $return_url = $this->input->get('return_url');
                messages($messages); ?>

                <form action="<?php echo site_url('/content/image/'.$image['id'].((!empty($return_url))?'?return_url='.urlencode($return_url):'')); ?>" enctype="multipart/form-data" method="post" class="clearfix no-margin">

                    <input type="hidden" name="id" id="id" value="<?php echo $image['id']; ?>" />

                    <div class="row">
                        <div class="small-5 columns">
                            <label for="type"><?php echo lang('ct_img_alt') ?>
                                <input type="text" name="alt" id="alt" placeholder="<?php echo lang('ct_img_alt') ?>" value="<?php echo $image['alt'] ?>" />
                            </label>
                        </div>
                        <div class="small-5 columns">
                            <label for="type"><?php echo lang('ct_img_link') ?>
                                <input type="text" name="link" id="link" placeholder="<?php echo lang('ct_img_link') ?>" value="<?php echo $image['link'] ?>" />
                            </label>
                        </div>
                        <div class="small-2 columns">
                            <label for="sce_id"><?php echo lang('ct_id') ?>
                                <input type="text" name="sce_id" id="sce_id" placeholder="<?php echo lang('ct_id') ?>" value="<?php echo $image['sce_id'] ?>" />
                            </label>
                        </div>
                    </div>

                    <?php if( !empty($image['path']) ): ?>
                    <div class="image-container">
                        <img src="<?php echo upload_url($image['path']) ?>" alt="<?php echo html_escape($image['alt']) ?>" />
                    </div>
                    <p class="text-center"><a href="<?php echo current_url().'?delete=true'.((!empty($return_url))?'&return_url='.urlencode($return_url):''); ?>"><i class="fa fa-trash-o"></i> <?php echo lang('ct_img_delete') ?></a></p>
                    <?php endif; ?>

                    <p>&nbsp;</p>

                    <div class="row">
                        <div class="small-6 columns">
                            <label for="upload"><?php echo lang('ct_img_upload') ?>:
                                <input type="file" id="upload" name="upload" size="20" />
                            </label>
                        </div>
                        <div class="small-6 columns text-right">
                            <label for="lightbox">
                                <input type="checkbox" id="lightbox" name="lightbox" value="1" <?php echo (($image['lightbox']==1)?'checked="checked"':''); ?> />
                                <?php echo lang('ct_img_lightbox') ?>
                            </label>
                        </div>
                    </div>

                    <div class="clearfix">
                        <?php
                        if( !empty($return_url) ):
                            ?>
                            <a href="<?php echo $return_url; ?>" class="button left no-margin top-margin grey" target="_parent"><i class="fa fa-caret-left"></i> <?php echo lang('back') ?></a>
                        <?php else: ?>
                            <a href="<?php echo site_url('/content/?active=images'); ?>" class="button left no-margin top-margin grey"><i class="fa fa-caret-left"></i> <?php echo lang('back') ?></a>
                        <?php endif; ?>

                        <ul class="button-group right top-margin">
                            <li><a href="<?php echo site_url('/content?active=images&del='.$image['id']) ?>" class="button no-margin del confirm-button" data-confirm="<?php echo lang('delete') ?>?"><i class="fa fa-trash-o"></i></a></li>
                            <li><button type="submit" name="save" id="save" value="save" class="button no-margin"><i class="fa fa-floppy-o"></i> <?php echo lang('save') ?></button></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
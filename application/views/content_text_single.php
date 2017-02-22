<div class="wrapper">
    <div class="row">
        <div class="small-12 columns">
            <div class="white-wrapper">

                <?php
                $return_url = $this->input->get('return_url');
                messages($messages); ?>

                <form action="<?php echo site_url('/content/text/'.$text['id'].((!empty($return_url))?'?return_url='.urlencode($return_url):'')); ?>" method="post" class="clearfix no-margin">

                    <input type="hidden" name="id" id="id" value="<?php echo $text['id']; ?>" />

                    <div class="row">
                        <div class="small-6 columns <?php echo ((user_model::$group != 1)?'hide':'') ?>">
                            <label for="type"><?php echo lang('ct_txt_type') ?>
                                <select name="type" id="type">
                                    <option value="editor" <?php echo (($text['type']=='editor')?'selected="selected"':'') ?>><?php echo lang('ct_editor_type_editor') ?></option>
                                    <option value="html" <?php echo (($text['type']=='html')?'selected="selected"':'') ?>><?php echo lang('ct_editor_type_html') ?></option>
                                    <option value="long" <?php echo (($text['type']=='long')?'selected="selected"':'') ?>><?php echo lang('ct_editor_type_long') ?></option>
                                    <option value="short" <?php echo (($text['type']=='short')?'selected="selected"':'') ?>><?php echo lang('ct_editor_type_short') ?></option>
                                </select>
                            </label>
                        </div>
                        <div class="small-6 columns">
                            <label for="sce_id"><?php echo lang('ct_id') ?>
                                <input type="text" name="sce_id" id="sce_id" placeholder="<?php echo lang('ct_id') ?>" value="<?php echo $text['sce_id'] ?>" />
                            </label>
                        </div>
                    </div>

                    <textarea name="text" id="text" cols="40" rows="25" style="<?php echo (($text['type']=='html')?'display:none;':''); ?>"><?php echo $text['text'] ?></textarea>

                    <?php
                    if( $text['type'] == 'html' ):
                    ?>
                        <div id="ace-editor"><?php echo html_escape($text['text']) ?></div>
                        <div id="statusBar" class="text-right"></div>
                    <?php
                    endif;
                    ?>

                    <p class="clearfix content-meta">
                        <span class="left text-left">
                            <strong><?php echo lang('ct_txt_creation_date') ?>:</strong><br />
                            <?php echo date(date_format, strtotime($text['created'])) ?>
                        </span>
                        <span class="right text-right">
                            <strong><?php echo lang('ct_txt_last_update') ?>:</strong><br />
                            <?php echo date(date_format, strtotime($text['modified'])) ?>
                        </span>
                    </p>

                    <div class="clearfix">
                        <?php
                        if( !empty($return_url) ):
                        ?>
                            <a href="<?php echo $return_url; ?>" class="button left no-margin top-margin grey" target="_parent"><i class="fa fa-caret-left"></i> <?php echo lang('back') ?></a>
                        <?php else: ?>
                        <a href="<?php echo site_url('/content/?active=text'); ?>" class="button left no-margin top-margin grey"><i class="fa fa-caret-left"></i> <?php echo lang('back') ?></a>
                        <?php endif; ?>

                        <ul class="button-group right top-margin">
                            <li><a href="<?php echo site_url('/content?active=text&del='.$text['id']) ?>" class="button no-margin del confirm-button" data-confirm="<?php echo lang('delete') ?>?"><i class="fa fa-trash-o"></i></a></li>
                            <li><button type="submit" name="save" id="save" value="save" class="button no-margin"><i class="fa fa-floppy-o"></i> <?php echo lang('save') ?></button></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="row">
        <ul class="tabs" data-tab>
            <li class="tab-title <?php echo (($active=='text'||$active==false)?'active':'') ?>"><a href="#panel-1"><i class="fa fa-file-text-o"></i> <?php echo lang('ct_tab_text') ?></a></li>
            <li class="tab-title <?php echo (($active=='images')?'active':'') ?>"><a href="#panel-2"><i class="fa fa-file-image-o"></i> <?php echo lang('ct_tab_images') ?></a></li>
            <li class="tab-title <?php echo (($active=='files')?'active':'') ?>"><a href="#panel-3"><i class="fa fa-file-archive-o"></i> <?php echo lang('ct_tab_files') ?></a></li>
        </ul>
        <div class="tabs-content">

            <div class="content <?php echo (($active=='text'||$active==false)?'active':'') ?>" id="panel-1">

                <?php messages($messages); ?>

                <?php
                if( $text != false && is_array($text) ):
                    ?>

                    <form action="<?php echo site_url('/content?active=text'); ?>" method="post" class="clearfix no-margin">
                        <div class="row collapse">
                            <div class="small-10 medium-11 columns">
                                <input type="text" name="text-q" id="text-q" placeholder="<?php echo lang('ct_tab_search') ?>" value="<?php echo $text_q ?>" />
                            </div>
                            <div class="small-2 medium-1 columns">
                                <button type="submit" class="button postfix"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                    <table class="content-table foundation-table">
                        <thead>
                        <tr>
                            <th><?php echo lang('ct_id') ?></th>
                            <th><?php echo lang('ct_txt_type') ?></th>
                            <th><?php echo lang('ct_txt_content') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($text as $item): ?>
                            <tr>
                                <td><?php echo html_escape($item['sce_id']) ?></td>
                                <td><?php type_helper(html_escape($item['type'])) ?></td>
                                <td class="clearfix">
                                    <a href="#" data-dropdown="text-dropdown-<?php echo $item['sce_id']; ?>" class="left dropdown-link"><?php echo character_limiter(html_escape(strip_tags($item['text'])), 60) ?></a>
                                    <div id="text-dropdown-<?php echo $item['sce_id']; ?>" data-dropdown-content class="f-dropdown medium content">
                                        <?php echo $item['text'];?>
                                    </div>

                                    <ul class="button-group right">
                                        <li><a href="<?php echo site_url('/content/text/'.$item['id']) ?>" class="button tiny"><?php echo lang('edit') ?></a></li>
                                        <li><a href="<?php echo site_url('/content?active=text&del='.$item['id']) ?>" class="button tiny secondary confirm-button" data-confirm="<?php echo lang('delete') ?>?"><i class="fa fa-trash-o"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="panel no-content">
                        <h5><?php echo lang('ct_empty_msg_empty_text_h') ?></h5>
                        <p><?php echo lang('ct_empty_msg_empty_text_t') ?></p>

                        <?php if($this->user_model->can_user_access('developer')): ?>
                        <p><a href="<?php echo site_url('developer?active=text') ?>" class="button tiny" style="margin-bottom: 0"><?php echo lang('show_me_how') ?></a></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="content <?php echo (($active=='images')?'active':'') ?>" id="panel-2">

                <?php messages($messages); ?>

                <?php
                if( $image != false && is_array($image) ){
                    ?>
                    <form action="<?php echo site_url('/content?active=images'); ?>" method="post" class="clearfix no-margin">
                        <div class="row collapse">
                            <div class="small-10 medium-11 columns">
                                <input type="text" name="image-q" id="image-q" placeholder="<?php echo lang('ct_tab_search') ?>" value="<?php echo $image_q ?>" />
                            </div>
                            <div class="small-2 medium-1 columns">
                                <button type="submit" class="button postfix"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <?php
                    $i = 1;
                    foreach($image as $item):
                        if( $i == 1 ) {
                            echo '<div class="row row-with-margin" data-equalizer>';
                        }

                        echo '<div class="small-4 columns">';
                            echo '<div class="image-container" data-equalizer-watch>';

                                if( !empty($item['path']) ) {
                                    echo '<a href="'.site_url('/content/image/'.$item['id']).'" data-tooltip class="has-tip" title="'.html_escape($item['alt']).'"><img src="'.upload_url($item['path']).'" alt="'.html_escape($item['alt']).'" /></a>';
                                } else {
                                    echo '<a href="'.site_url('/content/image/'.$item['id']).'" data-tooltip class="has-tip" title="'.html_escape($item['alt']).'"><span class="img-placeholder"><i class="fa fa-file-image-o"></i></span></a>';
                                }

                            echo '</div>';
                        echo '</div>';

                        if( $i == 3 ) {
                            echo '</div>';
                            $i = 1;
                        } else {
                            $i++;
                        }
                    endforeach;

                    if( $i != 1 ) {
                        echo '</div>';
                    }

                }else{ ?>
                    <div class="panel no-content">
                        <h5><?php echo lang('ct_empty_msg_empty_img_h') ?></h5>
                        <p><?php echo lang('ct_empty_msg_empty_img_t') ?></p>

                        <?php if($this->user_model->can_user_access('developer')): ?>
                        <p><a href="<?php echo site_url('developer?active=image') ?>" class="button tiny" style="margin-bottom: 0"><?php echo lang('show_me_how') ?></a></p>
                        <?php endif; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="content <?php echo (($active=='files')?'active':'') ?>" id="panel-3">

                <?php messages($messages); ?>

                <?php
                if( $file != false && is_array($file) ):
                    ?>

                    <form action="<?php echo site_url('/content?active=files'); ?>" method="post" class="clearfix no-margin">
                        <div class="row collapse">
                            <div class="small-10 medium-11 columns">
                                <input type="text" name="file-q" id="file-q" placeholder="<?php echo lang('ct_tab_search') ?>" value="<?php echo $file_q ?>" />
                            </div>
                            <div class="small-2 medium-1 columns">
                                <button type="submit" class="button postfix"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                    <table class="content-table foundation-table">
                        <thead>
                        <tr>
                            <th><?php echo lang('ct_id') ?></th>
                            <th><?php echo lang('ct_lnk_text') ?></th>
                            <th><?php echo lang('ct_lnk_file') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($file as $item): ?>
                            <tr>
                                <td><?php echo html_escape($item['sce_id']) ?></td>
                                <td><?php echo character_limiter(html_escape(strip_tags($item['path'])), 30) ?></td>
                                <td class="clearfix">
                                    <span class="left"><?php echo character_limiter(html_escape(strip_tags($item['text'])), 60) ?></span>

                                    <ul class="button-group right">
                                        <li><a href="<?php echo site_url('/content/file/'.$item['id']) ?>" class="button tiny"><?php echo lang('edit') ?></a></li>
                                        <li><a href="<?php echo site_url('/content?active=files&del='.$item['id']) ?>" class="button tiny secondary confirm-button" data-confirm="<?php echo lang('delete') ?>?"><i class="fa fa-trash-o"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="panel no-content">
                        <h5><?php echo lang('ct_empty_msg_empty_file_h') ?></h5>
                        <p><?php echo lang('ct_empty_msg_empty_file_t') ?></p>

                        <?php if($this->user_model->can_user_access('developer')): ?>
                        <p><a href="<?php echo site_url('developer?active=file') ?>" class="button tiny" style="margin-bottom: 0"><?php echo lang('show_me_how') ?></a></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
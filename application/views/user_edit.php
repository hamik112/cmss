<div class="wrapper">
    <div class="row">
        <div class="small-12 columns">
            <div class="white-wrapper">
                <?php messages($messages); ?>

                <?php
                if( is_array($user) ) {
                    echo form_open('user/'.$user['id'], array('autocomplete' => 'off'));
                } else {
                    echo form_open('user/new', array('autocomplete' => 'off'));
                }
                ?>

                <div class="row">
                    <div class="small-12 medium-6 columns">
                        <label><?php echo lang('user_username') ?>
                            <input type="text" name="username" id="username" placeholder="<?php echo lang('user_username') ?>" value="<?php echo ((set_value('username'))?set_value('username'):html_escape($user['username'])) ?>" required="required" />
                        </label>
                    </div>
                    <div class="small-12 medium-6 columns">
                        <label><?php echo lang('user_email') ?>
                            <input type="email" name="email" id="email" placeholder="<?php echo lang('user_email') ?>" value="<?php echo ((set_value('email'))?set_value('email'):html_escape($user['email'])) ?>" required="required" />
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 medium-6 columns">
                        <label><?php echo lang('user_firstname') ?>
                            <input type="text" name="firstname" id="firstname" placeholder="<?php echo lang('user_firstname') ?>" value="<?php echo ((set_value('firstname'))?set_value('firstname'):html_escape($user['firstname'])) ?>" <?php //echo (($user==false)?'required="required"':'') ?> />
                        </label>
                    </div>
                    <div class="small-12 medium-6 columns">
                        <label><?php echo lang('user_surname') ?>
                            <input type="text" name="surname" id="surname" placeholder="<?php echo lang('user_surname') ?>" value="<?php echo ((set_value('surname'))?set_value('surname'):html_escape($user['surname'])) ?>" <?php //echo (($user==false)?'required="required"':'') ?> />
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 medium-6 columns">
                        <label><?php echo lang('user_password') ?>
                            <input type="password" name="password" id="password" placeholder="<?php echo lang('user_password') ?>" <?php echo (($user==false)?'required="required"':'') ?> />
                        </label>
                    </div>
                    <div class="small-12 medium-6 columns">
                        <label><?php echo lang('user_password') ?> (<?php echo lang('user_repeat') ?>)
                            <input type="password" name="password2" id="password2" placeholder="<?php echo lang('user_password') ?> (<?php echo lang('user_repeat') ?>)" <?php echo (($user==false)?'required="required"':'') ?> />
                        </label>
                    </div>
                </div>

                <div class="row">
                    <?php if( user_model::$group == 1 && $user['id'] != 1 ): ?>
                    <div class="small-12 medium-6 columns">
                        <label for="group"><?php echo lang('user_group') ?>
                            <select name="group" id="group" required="required">
                                <?php if( set_value('group') ) { $user['group'] = set_value('group'); } ?>
                                <option value="2" <?php echo (($user['group']==2)?'selected="selected"':'') ?>><?php echo lang('user_group_user') ?></option>
                                <option value="1" <?php echo (($user['group']==1)?'selected="selected"':'') ?>><?php echo lang('user_group_admin') ?></option>
                            </select>
                        </label>
                    </div>
                    <?php endif; ?>
                    <div class="small-12 medium-6 columns">

                    </div>
                </div>

                <div class="clearfix">
                    <?php if($this->user_model->can_user_access('user')): ?>
                    <a href="<?php echo site_url('/user/'); ?>" class="button left no-margin top-margin grey"><i class="fa fa-caret-left"></i> <?php echo lang('back') ?></a>
                    <?php endif; ?>

                    <button type="submit" name="save" id="save" value="save" class="button right no-margin top-margin"><i class="fa fa-floppy-o"></i> <?php echo lang('save') ?></button>
                    <?php if( is_array($user) && count($user) >= 3 && $user['id'] != user_model::$user_id && $user['id'] != 1 ): ?>
                        <a href="<?php echo site_url('/user/del/'.$user['id']); ?>" class="button right no-margin top-margin red confirm-button" data-confirm="<?php echo lang('delete') ?>?" style="margin-right: 20px;"><i class="fa fa-trash-o"></i> <?php echo lang('delete') ?></a>
                    <?php endif; ?>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
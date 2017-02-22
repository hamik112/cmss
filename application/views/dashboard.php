
<div class="wrapper dashboard-columns">
    <div class="row">
        <div class="small-12 large-6 columns">
            <div class="dashboard-column dark-blue">
                <div class="image-area">
                    <span class="icon status"></span>
                    <h2><?php echo lang('db_status') ?></h2>
                </div>
                <div class="inner">
                    <p id="update-check-message"><i class="fa fa-info"></i> <?php echo software_name.' v.'.software_version; ?></p>
                    <?php if( user_model::$group == 1 ): ?>
                    <div class="clearfix"><a href="<?php echo site_url('settings?active=system-info') ?>" class="button tiny right" id="system-info-update-btn" data-update="Update now"><?php echo lang('system_info') ?></a></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="small-12 large-6 columns">
            <div class="dashboard-column">
                <div class="image-area">
                    <span class="icon content"></span>
                    <h2><?php echo lang('db_content') ?></h2>
                </div>
                <div class="inner">
                    <p><?php echo lang('db_content_text') ?></p>
                    <div class="clearfix"><a href="<?php echo site_url('content') ?>" class="button tiny right"><?php echo lang('db_content') ?></a></div>
                </div>
            </div>
        </div>
        <?php if($this->user_model->can_user_access('files')): ?>
        <div class="small-12 large-6 columns">
            <div class="dashboard-column">
                <div class="image-area">
                    <span class="icon files"></span>
                    <h2><?php echo lang('db_files') ?></h2>
                </div>
                <div class="inner">
                    <p><?php echo lang('db_files_text') ?></p>
                    <div class="clearfix"><a href="<?php echo site_url('files') ?>" class="button tiny right"><?php echo lang('db_files') ?></a></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="small-12 large-6 columns">
            <div class="dashboard-column">
                <div class="image-area">
                    <span class="icon user"></span>
                    <h2><?php echo lang('db_user') ?></h2>
                </div>
                <div class="inner">
                    <?php if($this->user_model->can_user_access('user')): ?>
                    <p><?php echo lang('db_user_text') ?></p>
                    <?php else: ?>
                    <p><?php echo lang('db_user_text2') ?></p>
                    <?php endif; ?>

                    <?php if($this->user_model->can_user_access('user')): ?>
                    <div class="clearfix"><a href="<?php echo site_url('user') ?>" class="button tiny right"><?php echo lang('db_user') ?></a></div>
                    <?php else: ?>
                    <div class="clearfix"><a href="<?php echo site_url('user/'.user_model::$user_id) ?>" class="button tiny right"><?php echo lang('db_user') ?></a></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if($this->user_model->can_user_access('backup')): ?>
        <div class="small-12 large-6 columns">
            <div class="dashboard-column">
                <div class="image-area">
                    <span class="icon backup"></span>
                    <h2><?php echo lang('db_backup') ?></h2>
                </div>
                <div class="inner">
                    <p><?php echo lang('db_backup_text') ?></p>
                    <div class="clearfix"><a href="<?php echo site_url('backup') ?>" class="button tiny right"><?php echo lang('db_backup') ?></a></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($this->user_model->can_user_access('settings')): ?>
        <div class="small-12 large-6 columns">
            <div class="dashboard-column">
                <div class="image-area">
                    <span class="icon settings"></span>
                    <h2><?php echo lang('db_settings') ?></h2>
                </div>
                <div class="inner">
                    <p><?php echo lang('db_settings_text') ?></p>
                    <div class="clearfix"><a href="<?php echo site_url('settings') ?>" class="button tiny right"><?php echo lang('db_settings') ?></a></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>


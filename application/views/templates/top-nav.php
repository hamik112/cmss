<div class="sce-topbar clearfix">
    <a href="<?php echo site_url('dashboard') ?>" class="sce-logo-area">
        <?php
        $topbar_logo = trim($this->simplece_model->get_setting_val('topbar_logo'));

        if( !empty($topbar_logo) ) {
            echo '<img src="'.base_url(uploads_dir.'/'.$topbar_logo).'" alt="" class="custom-topbar-logo" />';
        } else {
            echo '<span class="sce-logo-typo">S</span>';
        }
        ?>
    </a>
    <?php if( ! defined('frontend') ): ?>
    <a href="<?php echo get_upper_dir_link(site_url()) ?>" id="frontend-link" target="_parent"><i class="fa fa-home"></i> <span><?php echo lang('nav_frontend') ?></span></a>
    <?php endif; ?>

    <nav>
        <ul>
            <?php if( $this->simplece_model->get_setting_val('disable_dashboard') != 'yes' ): ?>
                <li><a href="<?php echo site_url('dashboard') ?>" class="sce-lightbox <?php nav_active($nav_active, 'dashboard'); ?>" data-lightbox-type="iframe"><i class="fa fa-bars"></i> <span><?php echo lang('nav_dashboard') ?></span></a></li>
            <?php endif; ?>
            <li><a href="<?php echo site_url('content') ?>" class="sce-lightbox <?php nav_active($nav_active, 'content'); ?>" data-lightbox-type="iframe"><i class="fa fa-file-code-o"></i> <span><?php echo lang('nav_content') ?></span></a></li>

            <?php if($this->user_model->can_user_access('files')): ?>
                <li><a href="<?php echo site_url('files') ?>" class="sce-lightbox <?php nav_active($nav_active, 'files'); ?>" data-lightbox-type="iframe"><i class="fa fa-folder-open-o"></i> <span><?php echo lang('nav_files') ?></span></a></li>
            <?php endif; ?>

            <?php if($this->user_model->can_user_access('developer')): ?>
                <li><a href="<?php echo site_url('developer') ?>" class="sce-lightbox <?php nav_active($nav_active, 'developer'); ?>" data-lightbox-type="iframe"><i class="fa fa-code"></i> <span><?php echo lang('nav_developer') ?></span></a></li>
            <?php endif; ?>

            <?php if($this->user_model->can_user_access('backup')): ?>
                <li><a href="<?php echo site_url('backup') ?>" class="sce-lightbox <?php nav_active($nav_active, 'backup'); ?>" data-lightbox-type="iframe"><i class="fa fa-database"></i> <span><?php echo lang('nav_backup') ?></span></a></li>
            <?php endif; ?>

            <?php if($this->user_model->can_user_access('user')): ?>
                <li><a href="<?php echo site_url('user') ?>" class="sce-lightbox <?php nav_active($nav_active, 'user'); ?>" data-lightbox-type="iframe"><i class="fa fa-users"></i> <span><?php echo lang('nav_user') ?></span></a></li>
            <?php else: ?>
                <li><a href="<?php echo site_url('user/'.user_model::$user_id) ?>" class="sce-lightbox <?php nav_active($nav_active, 'user'); ?>" data-lightbox-type="iframe"><i class="fa fa-users"></i> <span><?php echo lang('nav_user_profile') ?></span></a></li>
            <?php endif; ?>

            <?php if($this->user_model->can_user_access('settings')): ?>
                <li><a href="<?php echo site_url('settings') ?>" class="sce-lightbox <?php nav_active($nav_active, 'settings'); ?>" data-lightbox-type="iframe"><i class="fa fa-cogs"></i> <span><?php echo lang('nav_settings') ?></span></a></li>
            <?php endif; ?>
            <li><a href="<?php echo site_url('logout') ?>" class="logout <?php nav_active($nav_active, 'logout'); ?>"><i class="fa fa-lock"></i> <span><?php echo lang('nav_logout') ?></span></a></li>
        </ul>
    </nav>
</div>
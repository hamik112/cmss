<div class="wrapper">

    <form action="<?php echo site_url('settings'); ?>" enctype="multipart/form-data" method="post" class="clearfix no-margin">

        <input type="hidden" name="active" id="active" value="" />

        <div class="row">

            <ul class="tabs" data-tab>
                <li class="tab-title <?php echo (($active=='general'||$active==false)?'active':'') ?>"><a href="#panel-1"><i class="fa fa-cogs"></i> <?php echo lang('settings_tab1') ?></a></li>
                <?php if( user_model::$group == 1 ): ?>
                <li class="tab-title <?php echo (($active=='user-roles')?'active':'') ?>"><a href="#panel-2"><i class="fa fa-users"></i> <?php echo lang('settings_tab2') ?></a></li>
                <?php endif; ?>
                <li class="tab-title <?php echo (($active=='customization')?'active':'') ?>"><a href="#panel-3"><i class="fa fa-crop"></i> <?php echo lang('settings_tab3') ?></a></li>
                <?php if( user_model::$group == 1 ): ?>
                <li class="tab-title <?php echo (($active=='system-info')?'active':'') ?>"><a href="#panel-4"><i class="fa fa-cloud-download"></i> <?php echo lang('settings_tab4') ?></a></li>
                <?php endif; ?>
            </ul>
            <div class="tabs-content">
                <div class="content <?php echo (($active=='general'||$active==false)?'active':'') ?>" id="panel-1">

                    <?php messages($messages); ?>

                    <h3><?php echo lang('settings_general_h') ?></h3>

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <label for="code_style"><?php echo lang('settings_code_style') ?>
                                <select name="code_style" id="code_style">
                                    <option value="html5" <?php echo ((get_setting('code_style')=='html5')?'selected="selected"':'') ?>>HTML5 / HTML</option>
                                    <option value="xhtml" <?php echo ((get_setting('code_style')=='xhtml')?'selected="selected"':'') ?>>XHTML</option>
                                </select>
                            </label>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <label for="editor_mode"><?php echo lang('settings_editor_mode') ?>
                                <select name="editor_mode" id="editor_mode">
                                    <option value="Basic" <?php echo ((get_setting('editor_mode')=='Basic')?'selected="selected"':'') ?>><?php echo lang('settings_editor_mode_basic') ?></option>
                                    <option value="Standard" <?php echo ((get_setting('editor_mode')=='Standard')?'selected="selected"':'') ?>><?php echo lang('settings_editor_mode_standard') ?></option>
                                    <option value="Full" <?php echo ((get_setting('editor_mode')=='Full')?'selected="selected"':'') ?>><?php echo lang('settings_editor_mode_full') ?></option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <label for="disable_dashboard"><?php echo lang('settings_disable_dashboard') ?>
                                <select name="disable_dashboard" id="disable_dashboard">
                                    <option value="no" <?php echo ((get_setting('disable_dashboard')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('disable_dashboard')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </label>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <label for="disable_login_animation"><?php echo lang('settings_disable_login_animation') ?>
                                <select name="disable_login_animation" id="disable_login_animation">
                                    <option value="no" <?php echo ((get_setting('disable_login_animation')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('disable_login_animation')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <label for="disable_lightbox"><?php echo lang('settings_disable_lightbox') ?>
                                <select name="disable_lightbox" id="disable_lightbox">
                                    <option value="no" <?php echo ((get_setting('disable_lightbox')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('disable_lightbox')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </label>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <label for="login_redirect"><?php echo lang('settings_login_redirect') ?>
                                <select name="login_redirect" id="login_redirect">
                                    <option value="backend" <?php echo ((get_setting('login_redirect')=='backend')?'selected="selected"':'') ?>><?php echo lang('settings_backend') ?></option>
                                    <option value="frontend" <?php echo ((get_setting('login_redirect')=='frontend')?'selected="selected"':'') ?>><?php echo lang('settings_frontend') ?></option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <label for="disable_cache"><?php echo lang('settings_disable_cache') ?>
                                <select name="disable_cache" id="disable_cache">
                                    <option value="no" <?php echo ((get_setting('disable_cache')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('disable_cache')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </label>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <label for="login_captcha"><?php echo lang('settings_login_captcha') ?>
                                <select name="login_captcha" id="login_captcha">
                                    <option value="no" <?php echo ((get_setting('login_captcha')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('login_captcha')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <?php
                    /**
                     * License Part
                     */

                    if( demo_mode !== true ):
                    ?>
                    <hr />

                    <h3><?php echo lang('settings_license_h') ?></h3>

                    <p><i class="fa fa-info"></i> <?php echo software_name.' v.'.software_version; ?></p>

                    <label for="sce_id"><?php echo lang('settings_license_key') ?> (<a href="http://support.envato.com/index.php?/Knowledgebase/Article/View/506/54/where-can-i-find-my-purchase-code" target="_blank"><?php echo lang('settings_license_key_help') ?></a>):
                        <input type="text" name="license_key" id="license_key" placeholder="<?php echo lang('settings_license_key') ?>" value="<?php echo html_escape(get_setting('license_key')) ?>" />
                    </label>

                    <p class="text-center"><?php echo lang('settings_license_help') ?></p>
                    <?php
                    /**
                     * License Part End
                     */
                    endif;
                    ?>

                    <div class="clearfix">
                        <button type="submit" name="save" value="save" class="button right no-margin top-margin" onclick="jQuery('#active').val('general'); return true;"><i class="fa fa-floppy-o"></i> <?php echo lang('save') ?></button>
                    </div>
                </div>
                <?php if( user_model::$group == 1 ): ?>
                <div class="content <?php echo (($active=='user-roles')?'active':'') ?>" id="panel-2">
                    <table class="user-group-settings foundation-table" style="width: 100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th style="width: 100px" class="text-center"><?php echo lang('user_group_user') ?></th>
                            <th style="width: 100px" class="text-center"><?php echo lang('user_group_admin') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo lang('settings_ca_files') ?></td>
                            <td>
                                <select name="user_files_menu" id="user_files_menu">
                                    <option value="no" <?php echo ((get_setting('user_files_menu')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('user_files_menu')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </td>
                            <td class="text-center"><i class="fa fa-check-square-o"></i></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('settings_ca_developer') ?></td>
                            <td>
                                <select name="user_developer_menu" id="user_developer_menu">
                                    <option value="no" <?php echo ((get_setting('user_developer_menu')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('user_developer_menu')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </td>
                            <td class="text-center"><i class="fa fa-check-square-o"></i></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('settings_ca_backup') ?></td>
                            <td>
                                <select name="user_backup_menu" id="user_backup_menu">
                                    <option value="no" <?php echo ((get_setting('user_backup_menu')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('user_backup_menu')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </td>
                            <td class="text-center"><i class="fa fa-check-square-o"></i></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('settings_ca_user') ?></td>
                            <td>
                                <select name="user_user_menu" id="user_user_menu">
                                    <option value="no" <?php echo ((get_setting('user_user_menu')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('user_user_menu')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </td>
                            <td class="text-center"><i class="fa fa-check-square-o"></i></td>
                        </tr>
                        <tr>
                            <td><?php echo lang('settings_ca_settings') ?></td>
                            <td>
                                <select name="user_settings_menu" id="user_settings_menu">
                                    <option value="no" <?php echo ((get_setting('user_settings_menu')=='no')?'selected="selected"':'') ?>><?php echo lang('settings_no') ?></option>
                                    <option value="yes" <?php echo ((get_setting('user_settings_menu')=='yes')?'selected="selected"':'') ?>><?php echo lang('settings_yes') ?></option>
                                </select>
                            </td>
                            <td class="text-center"><i class="fa fa-check-square-o"></i></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="clearfix">
                        <button type="submit" name="save" value="save" class="button right no-margin top-margin" onclick="jQuery('#active').val('user-roles'); return true;"><i class="fa fa-floppy-o"></i> <?php echo lang('save') ?></button>
                    </div>
                </div>
                <?php endif; ?>
                <div class="content <?php echo (($active=='customization')?'active':'') ?>" id="panel-3">

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <label for="fe_color_1"><?php echo lang('settings_fe_color_1') ?> (<a href="#" class="color-reset" data-field="#fe_color_1" data-color="<?php echo fe_color_1 ?>"><?php echo lang('settings_reset') ?></a>)
                                <input type="text" name="fe_color_1" id="fe_color_1" placeholder="<?php echo lang('settings_fe_color_1') ?>" value="<?php echo html_escape(get_setting('fe_color_1', fe_color_1)) ?>" class="open-colorpicker" data-colorpicker="#colorpicker1" />
                            </label>
                            <div id="colorpicker1" class="colorpicker"></div>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <label for="fe_color_2"><?php echo lang('settings_fe_color_2') ?> (<a href="#" class="color-reset" data-field="#fe_color_2" data-color="<?php echo fe_color_2 ?>"><?php echo lang('settings_reset') ?></a>)
                                <input type="text" name="fe_color_2" id="fe_color_2" placeholder="<?php echo lang('settings_fe_color_2') ?>" value="<?php echo html_escape(get_setting('fe_color_2', fe_color_2)) ?>" class="open-colorpicker" data-colorpicker="#colorpicker2" />
                            </label>
                            <div id="colorpicker2" class="colorpicker"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <label for="software_name"><?php echo lang('settings_software_name') ?>
                                <input type="text" name="software_name" id="software_name" placeholder="<?php echo lang('settings_software_name') ?>" value="<?php echo html_escape(get_setting('software_name')) ?>" />
                            </label>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <label for="copyright"><?php echo lang('settings_copyright') ?>
                                <input type="text" name="copyright" id="copyright" placeholder="<?php echo lang('settings_copyright') ?>" value="<?php echo html_escape(get_setting('copyright')) ?>" />
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <?php
                            $login_logo = get_setting('login_logo');

                            if( $login_logo ) {
                                echo '<p class="text-center settings-image-preview">';
                                echo '<img src="'.base_url(uploads_dir.'/'.$login_logo).'" alt="Login-Logo" class="responsive-image" /><br />';
                                echo '<label><input type="checkbox" name="delete_login_logo" id="delete_login_logo" value="delete" /> '.lang('delete').'</label>';
                                echo '</p>';
                            }
                            ?>
                            <label for="login_logo"><?php echo lang('settings_login_logo') ?>
                                <input type="file" id="login_logo" name="login_logo" size="20" />
                            </label>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <?php
                            $topbar_logo = get_setting('topbar_logo');

                            if( $topbar_logo ) {
                                echo '<p class="text-center settings-image-preview">';
                                echo '<img src="'.base_url(uploads_dir.'/'.$topbar_logo).'" alt="Topbar-Logo" class="responsive-image" /><br />';
                                echo '<label><input type="checkbox" name="delete_topbar_logo" id="delete_topbar_logo" value="delete" /> '.lang('delete').'</label>';
                                echo '</p>';
                            }
                            ?>
                            <label for="topbar_logo"><?php echo lang('settings_topbar_logo') ?>
                                <input type="file" id="topbar_logo" name="topbar_logo" size="20" />
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 medium-6 columns">
                            <?php
                            $login_background = get_setting('login_background');

                            if( $login_background ) {
                                echo '<p class="text-center settings-image-preview">';
                                echo '<img src="'.base_url(uploads_dir.'/'.$login_background).'" alt="Login-Background" class="responsive-image" /><br />';
                                echo '<label><input type="checkbox" name="delete_login_background" id="delete_login_background" value="delete" /> '.lang('delete').'</label>';
                                echo '</p>';
                            }
                            ?>
                            <label for="login_background"><?php echo lang('settings_login_background') ?>
                                <input type="file" id="login_background" name="login_background" size="20" />
                            </label>
                        </div>
                        <div class="small-12 medium-6 columns">
                            <?php
                            $backend_background = get_setting('backend_background');

                            if( $backend_background ) {
                                echo '<p class="text-center settings-image-preview">';
                                echo '<img src="'.base_url(uploads_dir.'/'.$backend_background).'" alt="Backend-Background" class="responsive-image" /><br />';
                                echo '<label><input type="checkbox" name="delete_backend_background" id="delete_backend_background" value="delete" /> '.lang('delete').'</label>';
                                echo '</p>';
                            }
                            ?>
                            <label for="backend_background"><?php echo lang('settings_backend_background') ?>
                                <input type="file" id="backend_background" name="backend_background" size="20" />
                            </label>
                        </div>
                    </div>

                    <p style="padding-top: 40px"><?php echo sprintf(lang('settings_custom_css'), custom_backend_css, FCPATH, software_name) ?></p>

                    <div class="clearfix">
                        <button type="submit" name="save" value="save" class="button right no-margin top-margin" onclick="jQuery('#active').val('customization'); return true;"><i class="fa fa-floppy-o"></i> <?php echo lang('save') ?></button>
                    </div>
                </div>
                <?php if( user_model::$group == 1 ): ?>
                <div class="content system-info-tab <?php echo (($active=='system-info')?'active':'') ?>" id="panel-4">
                    <h3><?php echo lang('settings_tab4') ?></h3>
                    <p class="table-list clearfix"> <strong><?php echo lang('update_installed') ?>:</strong> <?php echo software_name.' v.<span class="current-version">'.software_version.'</span>'; ?><br />
                    <strong><?php echo lang('update_available') ?>:</strong> <?php echo software_name; ?> <span class="fill-update-version">N/A</span><br />
                    <strong><?php echo lang('update_last_check') ?>:</strong> <?php echo last_update_check_info(); ?></p>

                    <p class="table-list clearfix"><strong><?php echo lang('setup_step1_php') ?>:</strong> <?php echo phpversion(); ?></p>

                    <p class="table-list"><strong><i class="fa fa-info"></i> Software-Info:</strong> <?php echo copyright; ?>. All rights reserved.<br />
                    <strong></strong> <?php echo software_name; ?> was developed and maintained by Pascal Bajorat, Germany.</p>

                    <?php if( demo_mode !== true ): ?>
                    <div class="panel success hide" id="update-panel">
                        <h4><?php echo lang('update_panel_h') ?></h4>
                        <p class="update-check-message"></p>
                        <p><strong class="red"><?php echo lang('update_panel_note') ?>:</strong><br /><?php echo lang('update_panel_note_txt') ?></p>
                        <p class="no-margin" id="update-status"><a href="#" id="install-update" class="button green no-margin"><?php echo lang('update_panel_install_btn') ?></a></p>
                    </div>
                    <?php endif; ?>

                </div>
                <?php endif; ?>
            </div>
        </div>

    </form>

</div>
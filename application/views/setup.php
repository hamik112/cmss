<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title><?php echo software_name.' v.'.software_version; ?></title>

    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico') ?>" type="image/x-icon" />
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico') ?>" type="image/x-icon" />

    <link rel="stylesheet" href="<?php echo base_url('assets/css/foundation.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css') ?>" />
    <script src="<?php echo base_url('assets/js/vendor/modernizr.js') ?>"></script>

</head>
<?php
$error = false;
?>
<body class="backend setup">

    <div class="wrapper">
        <a href="https://simplece.com" target="_blank" class="sce_simplece">
            <span class="sce_simplece-logo">S</span><br />simpleCE
        </a>
        <div class="row">
            <div class="small-12 columns">
                <div class="white-wrapper">

                    <noscript>
                        <div class="panel error">
                            <p><?php echo lang('setup_js_warning') ?></p>
                        </div>
                    </noscript>

                    <div id="welcome" class="installation-step">
                        <h3><?php echo lang('setup_step1_h') ?></h3>
                        <p><?php echo lang('setup_step1_welcome') ?></p>

                        <a href="#" data-dropdown="drop1" class="button dropdown small"><?php echo lang('setup_step1_change_lang') ?></a><br />
                        <ul id="drop1" data-dropdown-content class="f-dropdown">
                            <li><a href="<?php echo current_url().'?language=english' ?>"><?php echo lang('setup_step1_english') ?></a></li>
                            <li><a href="<?php echo current_url().'?language=german' ?>"><?php echo lang('setup_step1_german') ?></a></li>
                        </ul>

                        <div class="row">
                            <div class="small-12 medium-6 columns">
                                <h3><?php echo lang('setup_step1_requirements') ?></h3>

                                <p>
                                    <?php
                                    if(version_compare(PHP_VERSION, '5.4') >= 0){
                                        echo '&raquo; '.lang('setup_step1_php').': '.phpversion().' <i class="fa fa-check green"></i><br />';
                                    } else if(version_compare(PHP_VERSION, '5.3') >= 0){
                                        echo '&raquo; '.lang('setup_step1_php').': '.phpversion().' <i class="fa fa-check yellow"></i><br />';
                                    } else {
                                        $error = true;
                                        echo '&raquo; '.lang('setup_step1_php').': '.phpversion().' <i class="fa fa-times red"></i><br />';
                                    }

                                    if( extension_loaded('gd') && function_exists('gd_info') ) {
                                        echo '&raquo; '.lang('setup_step1_image_lib').' <i class="fa fa-check green"></i><br />';
                                    } elseif( extension_loaded('imagick') && class_exists('Imagick') ) {
                                        echo '&raquo; '.lang('setup_step1_image_lib').' <i class="fa fa-check green"></i><br />';
                                    } else {
                                        echo '&raquo; '.lang('setup_step1_image_lib_error').' <i class="fa fa-check yellow"></i><br />';
                                    }
                                    ?>

                                    &raquo; <?php echo lang('setup_step1_mysql') ?><br />
                                </p>

                                <h3><?php echo lang('setup_step1_info2_h') ?></h3>
                                <p>
                                    <?php
                                    if(version_compare(PHP_VERSION, '5.3') >= 0){
                                        echo '&raquo; '.lang('setup_step1_php').': '.phpversion().' <i class="fa fa-check green"></i><br />';
                                    } else {
                                        echo '&raquo; '.lang('setup_step1_php').': '.phpversion().' <i class="fa fa-times red"></i><br />';
                                    }
                                    ?>

                                    <?php
                                    if( function_exists('curl_version') ){
                                        $curl_version = curl_version();
                                        echo '&raquo; '.lang('setup_step1_curl').' (installed: '.$curl_version['version'].') <i class="fa fa-check green"></i><br />';
                                    } else {
                                        echo '&raquo; '.lang('setup_step1_curl').' <i class="fa fa-times red"></i><br />';
                                    }
                                    ?>

                                    <?php
                                    if( function_exists('zip_open') && function_exists('zip_read') ){
                                        echo '&raquo; '.lang('setup_step1_zzlib').' <i class="fa fa-check green"></i><br />';
                                    } else {
                                        echo '&raquo; '.lang('setup_step1_zzlib').' <i class="fa fa-times red"></i><br />';
                                    }
                                    ?>
                                </p>

                                <!--h3><?php echo lang('setup_step1_info_h') ?></h3>
                                <p>&raquo; <?php echo lang('setup_step2_db_database') ?><br />
                                    &raquo; <?php echo lang('setup_step2_db_username') ?><br />
                                    &raquo; <?php echo lang('setup_step2_db_password') ?><br />
                                    &raquo; <?php echo lang('setup_step2_db_server') ?></p-->
                            </div>
                            <div class="small-12 medium-6 columns">
                                <h3><?php echo lang('setup_step1_file_permissions') ?></h3>

                                <p>
                                <?php
                                foreach( $dirs_to_check as $dir ) {
                                    if( $dir == 'config.php' && !is_really_writable(FCPATH.$dir) ) {
                                        continue;
                                    } else if( is_really_writable($dir) ) {
                                        echo '<i class="fa fa-check green"></i> '.basename($dir).'<br />';
                                    } else {
                                        $error = true;
                                        echo '<i class="fa fa-times red"></i> '.basename($dir).'<br />';
                                    }
                                }
                                ?>
                                </p>
                            </div>
                        </div>

                        <?php if( $error === false ): ?>
                            <p class="clearfix no-margin"><a href="#" class="button right no-margin installation-step-btn" data-show="license-check"><?php echo lang('setup_step1_nextstep') ?> &raquo;</a></p>
                        <?php else: ?>
                            <div class="panel error">
                                <p><?php echo lang('setup_step1_check_error') ?></p>
                            </div>

                            <p class="clearfix no-margin"><a href="JavaScript:window.location.reload();" class="button right no-margin"><?php echo lang('setup_step1_check_again') ?></a></p>
                        <?php endif; ?>
                    </div>

                    <div id="license-check" class="installation-step">
                        <h3><?php echo lang('settings_license_h') ?></h3>
                        <p></p>

                        <p><i class="fa fa-info"></i> <?php echo software_name.' v.'.software_version; ?></p>

                        <label for="sce_id"><?php echo lang('settings_license_key') ?> (<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank"><?php echo lang('settings_license_key_help') ?></a>):
                            <input type="text" name="license_key" id="license_key" placeholder="<?php echo lang('settings_license_key') ?>" value="" />
                        </label>

                        <p class="text-center"><?php echo lang('settings_license_help') ?></p>

                        <p class="clearfix no-margin"><a href="#" class="button right no-margin installation-step-btn" data-show="config"><?php echo lang('setup_step1_nextstep') ?> &raquo;</a></p>
                    </div>

                    <div id="config" class="installation-step">
                        <h3><?php echo lang('setup_step2_h') ?></h3>

                        <p><?php echo lang('setup_step2_desc') ?></p>

                        <form name="setup-data" id="setup-data" method="get">

                        <input type="hidden" name="license_key2" id="license_key2" value="" />
                        <input type="hidden" name="language" id="language" value="<?php echo setup_lang ?>" />

                        <div class="row">
                            <div class="small-12 medium-6 columns">
                                <h5><?php echo lang('setup_step2_user_system') ?></h5>

                                <label form="site_url"><?php echo lang('setup_step2_siteurl') ?>:
                                    <input type="text" name="site_url" id="site_url" placeholder="<?php echo lang('setup_step2_siteurl') ?>" value="<?php echo base_url() ?>" required="required" />
                                </label>

                                <br />

                                <label form="firstname"><?php echo lang('setup_step2_firstname') ?>:
                                    <input type="text" name="firstname" id="firstname" maxlength="200" value="" required="required" />
                                </label>

                                <label form="surname"><?php echo lang('setup_step2_surname') ?>:
                                    <input type="text" name="surname" id="surname" maxlength="200" value="" required="required" />
                                </label>

                                <label form="username"><?php echo lang('setup_step2_username') ?>:
                                    <input type="text" name="username" id="username" maxlength="100" value="admin" required="required" />
                                </label>

                                <label form="password"><?php echo lang('setup_step2_password') ?>:
                                    <input type="text" name="password" id="password" maxlength="32" value="" required="required" />
                                </label>

                                <label form="email"><?php echo lang('setup_step2_email') ?>:
                                    <input type="email" name="email" id="email" maxlength="200" value="" required="required" />
                                </label>
                            </div>
                            <div class="small-12 medium-6 columns">
                                <h5><?php echo lang('setup_step2_db_config') ?></h5>

                                <label form="driver"><?php echo lang('setup_step2_db_driver') ?>:
                                    <select name="driver" id="driver">
                                        <?php if( version_compare(PHP_VERSION, 7, '<') ): ?>
                                        <option value="mysql">MySQL</option>
                                        <?php endif; ?>
                                        <option value="mysqli" selected>MySQLi (<?php echo lang('setup_step2_db_recommended') ?>)</option>
                                    </select>
                                </label>

                                <br />

                                <label form="db_server"><?php echo lang('setup_step2_db_server') ?>:
                                    <input type="text" name="db_server" id="db_server" value="localhost" required="required" />
                                </label>

                                <label form="db_username"><?php echo lang('setup_step2_db_username') ?>:
                                    <input type="text" name="db_username" id="db_username" value="root" required="required" />
                                </label>

                                <label form="db_password"><?php echo lang('setup_step2_db_password') ?>:
                                    <input type="text" name="db_password" id="db_password" value="root" />
                                </label>

                                <label form="database"><?php echo lang('setup_step2_db_database') ?>:
                                    <input type="text" name="database" id="database" value="simplece" required="required" />
                                </label>

                                <label form="db_prefix"><?php echo lang('setup_step2_db_prefix') ?>:
                                    <input type="text" name="db_prefix" id="db_prefix" value="<?php echo db_prefix ?>" required="required" />
                                </label>
                            </div>
                        </div>

                        <div class="panel text-center">
                            <label for="demo-data">
                                <input type="checkbox" name="demo-data" id="demo-data" value="1" checked style="margin: 0" /> <?php echo lang('setup_step2_demo_data') ?>
                            </label>
                        </div>
                        </form>

                        <p class="clearfix no-margin"><a href="#" class="button right no-margin installation-step-btn" data-show="data-check"><?php echo lang('setup_step2_check_btn') ?> &raquo;</a></p>
                    </div>

                    <div id="data-check" class="installation-step">
                        <h3><?php echo lang('setup_step3_h') ?></h3>

                        <p class="hide-this-text"><?php echo lang('setup_step3_desc') ?></p>

                        <div class="progress hide">
                            <span class="meter" style="width: 10%"></span>
                        </div>

                        <p class="clearfix no-margin button-container"><a href="#" class="button right no-margin installation-step-btn" data-show="install"><?php echo lang('setup_step3_install_btn') ?> &raquo;</a></p>
                    </div>

                    <div id="finish" class="installation-step">
                        <h3><?php echo lang('setup_step4_h') ?></h3>

                        <p><?php echo lang('setup_step4_desc') ?></p>

                        <p><strong><?php echo lang('setup_step2_username') ?>:</strong> <span class="username_field"></span><br />
                            <strong><?php echo lang('setup_step2_password') ?>:</strong> <span class="password_field"></span></p>

                        <p class="clearfix no-margin"><a href="#" class="button right no-margin login-button"><?php echo lang('login_btn') ?> &raquo;</a></p>
                    </div>

                </div>

            </div>
        </div>

        <footer class="copyright">
            <?php echo copyright; ?>
        </footer>
    </div>

    <div class="hide">
        <div id="response-modal" class="reveal-modal" data-reveal>
            <div id="response-modal-content"></div>
            <a class="close-reveal-modal">&#215;</a>
        </div>

        <a href="#" id="response-modal-link" data-reveal-id="response-modal">open response modal</a>
    </div>

<script src="<?php echo base_url('assets/js/vendor/jquery.js') ?>"></script>
<script src="<?php echo base_url('assets/js/plugins.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/foundation.min.js') ?>"></script>
<script>
    setup_config = function(){
        jQuery.getJSON(site_url+'index.php/setup-config', form_data, function(data){

            if(data.return == 'true') {
                setTimeout(function(){
                    jQuery('#data-check .progress .meter').css('width', '50%');
                    setup_database_structure();
                }, 1000);
            } else {
                jQuery('#response-modal-content').html(data.return);
                jQuery('a#response-modal-link').trigger('click');
            }

        }).fail(function(){
            jQuery('#response-modal-content').html('Setup-Script is not reachable, check your Site-URL! ('+site_url+'index.php/setup-config) and internet connection.');
            jQuery('a#response-modal-link').trigger('click');
        });
    };

    setup_database_structure = function(){
        jQuery.getJSON(site_url+'index.php/setup-database-structure', form_data, function(data){

            if(data.return == 'true') {
                setTimeout(function(){
                    jQuery('#data-check .progress .meter').css('width', '80%');
                    setup_database();
                }, 1000);
            } else {
                jQuery('#response-modal-content').html(data.return);
                jQuery('a#response-modal-link').trigger('click');
            }

        }).fail(function(){
            jQuery('#response-modal-content').html('Setup-Script is not reachable, check your Site-URL! ('+site_url+'index.php/setup-database-structure) and internet connection.');
            jQuery('a#response-modal-link').trigger('click');
        });
    };

    setup_database = function(){
        jQuery.getJSON(site_url+'index.php/setup-database', form_data, function(data){

            if(data.return == 'true') {
                setTimeout(function(){
                    jQuery('#data-check .progress .meter').css('width', '100%');

                    jQuery('.username_field').text(jQuery('#username').val());
                    jQuery('.password_field').text(jQuery('#password').val());

                    jQuery('.login-button').attr('href', jQuery('#site_url').val());

                    setTimeout(function(){
                        jQuery('.installation-step').hide();
                        jQuery('#finish').show();
                    }, 1000);

                }, 1000);
            } else {
                jQuery('#response-modal-content').html(data.return);
                jQuery('a#response-modal-link').trigger('click');
            }

        }).fail(function(){
            jQuery('#response-modal-content').html('Setup-Script is not reachable, check your Site-URL! ('+site_url+'index.php/setup-database) and internet connection.');
            jQuery('a#response-modal-link').trigger('click');
        });
    };

    jQuery(document).foundation();

    jQuery(document).ready(function(){
        jQuery('.installation-step').hide();
        jQuery('#welcome').show();

        jQuery('.installation-step-btn').on('click', function(){

            thisStorage = this;

            element = jQuery(this).attr('data-show');

            if( element == 'data-check' ) {
                if( jQuery('#setup-data').valid() === true ) {

                    jQuery(thisStorage).text('<?php echo lang('setup_step3_wait') ?>');

                    site_url = jQuery('#site_url').val();
                    form_data = jQuery('#setup-data').serialize();

                    jQuery.getJSON(site_url+'index.php/setup-data-check', form_data, function(data){

                        if(data.return == 'true') {
                            jQuery('.installation-step').hide();
                            jQuery('#'+element).show();
                        } else {
                            jQuery(thisStorage).text('<?php echo lang('setup_step2_check_btn') ?> »');

                            jQuery('#response-modal-content').html(data.return);
                            jQuery('a#response-modal-link').trigger('click');
                        }

                    }).fail(function(){
                        jQuery(thisStorage).text('<?php echo lang('setup_step2_check_btn') ?> »');

                        jQuery('#response-modal-content').html('Data-Check is not reachable, check your Site-URL! ('+site_url+'index.php/setup-data-check)');
                        jQuery('a#response-modal-link').trigger('click');
                    });
                }
            } else if( element == 'install' ) {
                jQuery('#data-check .button-container, #data-check .hide-this-text').hide();
                jQuery('#data-check .progress').removeClass('hide');
                jQuery('#data-check h3').text('<?php echo lang('setup_step3_wait') ?>').css('text-align', 'center');

                setup_config();
            } else if( element == 'config' ) {
                jQuery(thisStorage).text('<?php echo lang('setup_step3_wait') ?>');

                license_key = jQuery('#license_key').val();

                jQuery.getJSON('<?php echo update_url ?>/license-check?license-key='+license_key, function(data){

                    if( data.status == 'valid' ) {
                        jQuery('#license_key2').val(license_key);
                        jQuery('.installation-step').hide();
                        jQuery('#'+element).show();
                    } else {
                        jQuery(thisStorage).text('<?php echo lang('setup_step1_nextstep') ?> »');

                        jQuery('#response-modal-content').html(data.message);
                        jQuery('a#response-modal-link').trigger('click');
                    }

                }).fail(function(){
                    jQuery('#response-modal-content').html('<?php echo lang('settings_license_server_unavailable') ?>');
                    jQuery('a#response-modal-link').trigger('click');
                });

            } else {
                jQuery('.installation-step').hide();
                jQuery('#'+element).show();
            }


            return false;
        });
    });
</script>
</body>
</html>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php
        $title = get_setting('software_name');
        if( !empty($title) && $title != false ) {
            echo html_escape($title);
        } else {
            echo software_name.' v.'.software_version;
        }
        ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/foundation.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css') ?>" />
    <script src="<?php echo base_url('assets/js/vendor/modernizr.js') ?>"></script>

    <?php
    $login_background = trim($this->simplece_model->get_setting_val('login_background'));

    if( !empty($login_background) ) {
    ?>
    <style type="text/css">
        body.login {
            background: url("<?php echo base_url(uploads_dir.'/'.$login_background); ?>") fixed no-repeat;
            background-size: cover;
        }
    </style>
    <?php
    }
    ?>
</head>
<body class="login">
    <a href="../" class="login-back-link">&larr; <?php echo lang('login_back') ?></a>
    <div id="login-box">
        <a href="http://www.simplece.com" target="_blank" class="sce_simplece">
            <?php
            $login_logo = trim($this->simplece_model->get_setting_val('login_logo'));

            if( !empty($login_logo) ) {
                echo '<img src="'.base_url(uploads_dir.'/'.$login_logo).'" alt="" class="custom-login-logo" />';
            } else {
                echo '<span class="sce_simplece-logo">S</span><br />simpleCE';
            }
            ?>
        </a>
        <form id="login-form" action="<?php echo site_url() ?>" method="post" autocomplete="off">
            <?php
            if( $login_error === true ) {
                echo '<span class="red error">'.lang('login_failed').'</span>';
            }
            ?>

            <div id="login-step-1">
                <label><?php echo lang('login_username') ?>:
                    <input type="text" name="username" placeholder="<?php echo lang('login_username') ?>" <?php if( demo_mode === true ) {echo 'value="'.demo_user.'"';} ?> required="required" autocomplete="off" />
                </label>

                <label><?php echo lang('login_password') ?>:
                    <input type="password" name="password" placeholder="<?php echo lang('login_password') ?>" <?php if( demo_mode === true ) {echo 'value="'.demo_pw.'"';} ?> required="required" autocomplete="off" />
                </label>
            </div>
            <div id="login-step-2" style="display: none;">
                <?php
                if( get_setting('login_captcha', 'no') == 'yes' && is_array($cap) ) {
                ?>

                    <label><?php echo $cap['image']; ?>
                        <input type="text" name="captcha" id="captcha" required="required" placeholder="Captcha Code" autocomplete="off" />
                    </label>
                <?php
                }
                ?>
            </div>

            <button type="submit" class="button expand" id="login-button" data-use-captcha="<?php echo ((get_setting('login_captcha', 'no') == 'yes' && is_array($cap))?'yes':'no'); ?>"><?php echo lang('login_btn') ?></button>

            <p class="copyright">
                <?php
                $copyright = get_setting('copyright');
                if( !empty($copyright) && $copyright != false ) {
                    echo html_escape($copyright);
                } else {
                    echo copyright;
                }
                ?>
            </p>

        </form>
    </div>

<script src="<?php echo base_url('assets/js/vendor/jquery.js') ?>"></script>
<script src="<?php echo base_url('assets/js/foundation.min.js') ?>"></script>
<?php if( get_setting('disable_login_animation') != 'yes' ): ?>
<script>
    jQuery(document).ready(function(){
        jQuery('#login-button').on('click', function(){

            cpatcha_status = jQuery(this).attr('data-use-captcha');

            if( cpatcha_status == 'no' ) {
                jQuery('#login-box form').animate({
                    opacity: 0
                }, 'slow', function(){
                    jQuery('#login-box form').hide();

                    jQuery('#login-box').animate({
                        marginTop: 115
                    }, 1000, function(){
                        window.setTimeout(function(){
                            jQuery('#login-form').submit();
                            return true;
                        }, 1000);
                    });
                });
            } else {
                jQuery('#login-step-1').hide();
                jQuery('#login-step-2').show();

                jQuery(this).attr('data-use-captcha', 'no');
            }

            return false;
        });
    });
</script>
<?php endif; ?>
<script>
    jQuery(document).foundation();
</script>
</body>
</html>
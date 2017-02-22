<!doctype html>
<html class="no-js admin-navigation" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>
        <?php
        $title = get_setting('software_name');
        if( !empty($title) && $title != false ) {
            echo html_escape($title);
        } else {
            echo software_name.' v.'.software_version;
        }
        ?>
    </title>

    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico') ?>" type="image/x-icon" />
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico') ?>" type="image/x-icon" />

    <link rel="stylesheet" href="<?php echo base_url('assets/css/foundation.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/nivo-lightbox/nivo-lightbox.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/nivo-lightbox/themes/default/default.css') ?>" />
    <?php if( $farbtastic ): ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/farbtastic/farbtastic.css') ?>" />
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css') ?>" />

    <?php if( file_exists(FCPATH.'custom-backend.css') ): ?>
    <link rel="stylesheet" href="<?php echo base_url(custom_backend_css) ?>" />
    <?php endif; ?>

    <script src="<?php echo base_url('assets/js/vendor/modernizr.js') ?>"></script>

    <?php
    $backend_background = trim($this->simplece_model->get_setting_val('backend_background'));

    if( !empty($backend_background) ) {
        ?>
        <style type="text/css">
            body {
                background: url("<?php echo base_url(uploads_dir.'/'.$backend_background); ?>") fixed no-repeat;
                background-size: cover;
            }
        </style>
    <?php
    }
    ?>
</head>
<body class="<?php body_class($body_class) ?>">

<?php require_once 'top-nav.php' ?>

<?php
$license_key = trim($this->simplece_model->get_setting_val('license_key'));

if( empty($license_key) ) {
?>
<div class="row">
    <div class="panel error">
        <h4><?php echo lang('license_info_h') ?></h4>
        <p><?php echo sprintf(lang('license_info_desc'), site_url('settings')) ?></p>
    </div>
</div>
<?php
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 09/07/14
 * Time: 22:07
 */

/* General Button and Text Elements */
$lang['view'] = "view";
$lang['edit'] = "edit";
$lang['delete'] = "delete";
$lang['back'] = "back";
$lang['save'] = "save";
$lang['show_me_how'] = "show me how";
$lang['system_info'] = "System-Info";

/* Demo-Mode */
$lang['demo_mode_h'] = "Demo-Mode";
$lang['demo_mode_desc'] = "Sorry, this feature is not available in the demo mode of simpleCE but you can use it in your own installation!";
$lang['demo_login'] = "Please use the following credentials for the <a href=\"".site_url()."\">demo login</a>: username \"<strong>".demo_user."</strong>\" and password \"<strong>".demo_pw."</strong>\"!<br />The demo will be resetted every 30 minutes!";

/* License Dialog */
$lang['license_info_h'] = "License Key";
$lang['license_info_desc'] = "Please enter your License Key or Item Purchase Code in the <a href=\"%s\"><strong>Settings</strong></a> to get the latest updates and support.";

/* Login */
$lang['login_back'] = "back to your website";
$lang['login_failed'] = "Your login credentials / captcha are incorrect!";
$lang['login_username'] = "Username";
$lang['login_password'] = "Password";
$lang['login_btn'] = "Login";

/* Frontend */
$lang['fe_edit'] = "edit";

/* Navigation */
$lang['nav_frontend'] = "Frontend";
$lang['nav_dashboard'] = "Dashboard";
$lang['nav_content'] = "Content";
$lang['nav_files'] = "Files";
$lang['nav_developer'] = "Developer";
$lang['nav_backup'] = "Backup &amp; Optimization";
$lang['nav_user'] = "User";
$lang['nav_user_profile'] = "Your Profile";
$lang['nav_settings'] = "Settings";
$lang['nav_logout'] = "Logout";

/* Dashboard */
$lang['db_status'] = "Status";
$lang['db_content'] = $lang['nav_content'];
$lang['db_files'] = $lang['nav_files'];
$lang['db_user'] = $lang['nav_user'];
$lang['db_backup'] = $lang['nav_backup'];
$lang['db_settings'] = $lang['nav_settings'];
$lang['db_content_text'] = 'In this area you can edit all your content elements like texts, images and files.';
$lang['db_files_text'] = 'Manage all your files stored on this webspace and edit the HTML, JS, CSS files of your website.';
$lang['db_user_text'] = 'Manage all users with access to the simpleCE backend and your own profile.';
$lang['db_user_text2'] = 'Here you can edit your user profile and login credentials.';
$lang['db_backup_text'] = 'Create backups of your simpleCE database or optimize and repair your database.';
$lang['db_settings_text'] = 'Customize simpleCE, manage user roles and configure the base system - everything here.';

/*
 * Content
 ********/
/* Tabs */
$lang['ct_tab_text'] = "Text";
$lang['ct_tab_images'] = "Images";
$lang['ct_tab_files'] = "Files";
$lang['ct_tab_search'] = "Search";

/* Content-Overview */
$lang['ct_id'] = "ID";
$lang['ct_txt_type'] = "Type";
$lang['ct_txt_content'] = "Content";
$lang['ct_del_success'] = "The selected content was successfully deleted!";

$lang['ct_lnk_text'] = "Link-Text";
$lang['ct_lnk_file'] = "File";
$lang['ct_lnk_size'] = "Size";
$lang['ct_lnk_date'] = "Date";

/* Content-Overview Messages */
$lang['ct_empty_msg_empty_text_h'] = "no content available";
$lang['ct_empty_msg_empty_text_t'] = "currently there are no content elements available, please insert your first content elements in your website!";
$lang['ct_empty_msg_empty_img_h'] = "no images available";
$lang['ct_empty_msg_empty_img_t'] = "currently there are no images available, please insert your first image elements in your website!";
$lang['ct_empty_msg_empty_file_h'] = "no files available";
$lang['ct_empty_msg_empty_file_t'] = "currently there are no files available, please insert your first content elements in your website!";

/* Editor Types */
$lang['ct_editor_type_editor'] = 'Editor';
$lang['ct_editor_type_html'] = 'HTML';
$lang['ct_editor_type_long'] = 'Long';
$lang['ct_editor_type_short'] = 'Short';

/* Content Text Single */
$lang['ct_txt_creation_date'] = 'Creation Date';
$lang['ct_txt_last_update'] = 'Last Update';

/* Content Text Validation Messages */
$lang['ct_validation_id'] = 'Please check the ID, it looks wrong';
$lang['ct_txt_validation_type'] = 'The given type is not allowed for this element';
$lang['ct_txt_validation_text'] = 'Your text is too long';
$lang['ct_txt_validation_unknown'] = 'Your text element could not be updated, there was an unexpected error.';
$lang['ct_txt_success'] = 'Your text element was updated successfully.';

/* Content Image Single */
$lang['ct_img_alt'] = 'Alt-Text';
$lang['ct_img_link'] = 'Link';
$lang['ct_img_upload'] = 'Replace current image';
$lang['ct_img_lightbox'] = 'Enable Lightbox for this image';
$lang['ct_img_delete'] = 'Delete Image';

/* Content Image Validation Messages */
$lang['ct_img_validation_path'] = 'The image path is too long';
$lang['ct_img_validation_alt'] = 'The alt text is too long';
$lang['ct_img_validation_link'] = 'The link url is too long';
$lang['ct_img_validation_lightbox'] = 'The Lightbox value is not valid';
$lang['ct_img_validation_unknown'] = 'Your image element could not be updated, there was an unexpected error.';
$lang['ct_img_success'] = 'Your image element was updated successfully.';

/* Content File Single */
$lang['ct_file_upload'] = 'Replace current file';
$lang['ct_file_delete'] = 'Delete File';

/* Content File Validation Messages */
$lang['ct_file_validation_path'] = 'The file path is too long';
$lang['ct_file_validation_text'] = 'The link text is too long';
$lang['ct_file_validation_unknown'] = 'Your file element could not be updated, there was an unexpected error.';
$lang['ct_file_success'] = 'Your file element was updated successfully.';


/*
 * Files
 ********/

/* Files-Overview */
$lang['files_tab1'] = 'Webspace Files';
$lang['files_tab2'] = 'Uploads';
$lang['files_name'] = 'Name';
$lang['files_size'] = 'Size';
$lang['files_error1_h'] = 'Sorry, could not open directory';
$lang['files_error1_t'] = 'The selected directory path is not valid or you have no permissions to access it.';
$lang['files_error2_h'] = 'Sorry, could not open the file';
$lang['files_error2_t'] = 'The selected file path is not valid or you have no permissions to access and edit the file.';
$lang['files_file_nw'] = 'File is not writable';
$lang['files_file_del'] = 'Delete';
$lang['files_file_edit'] = 'Edit';
$lang['files_updated'] = 'Successfully updated!';
$lang['files_not_updated'] = 'File could not be updated!';

$lang['files_file'] = 'File';
$lang['files_folder'] = 'Folder';
$lang['files_create_file_or_folder'] = 'Create a new file or folder';
$lang['files_add_file'] = 'Add a file';

/*
 * User
 ********/
$lang['user_id'] = 'ID';
$lang['user_username'] = 'Username';
$lang['user_password'] = 'Password';
$lang['user_repeat'] = 'repeat';
$lang['user_email'] = 'Email';
$lang['user_firstname'] = 'Firstname';
$lang['user_surname'] = 'Surname';
$lang['user_group'] = 'Role';
$lang['user_group_admin'] = 'Admin';
$lang['user_group_user'] = 'User';
$lang['user_create_new'] = 'Create a new User';
$lang['user_no_user_h'] = 'No Users found';
$lang['user_no_user_t'] = 'ups, there are no users in your database?! What have you done?';

$lang['user_validate_msg_username'] = 'Username ist not valid, it must between 4 and 100 chars!';
$lang['user_validate_msg_username2'] = 'Your username is already in use!';
$lang['user_validate_msg_email'] = 'Email ist not valid!';
$lang['user_validate_msg_email2'] = 'Your email is already in use!';
$lang['user_validate_msg_firstname'] = 'Firstname is not valid, it must between 2 and 200 chars!';
$lang['user_validate_msg_surname'] = 'Surname is not valid, it must between 2 and 200 chars!';
$lang['user_validate_msg_usergroup'] = 'Usergroup is not valid!';
$lang['user_validate_msg_password'] = 'Your password must between 4 and 32 chars!';
$lang['user_validate_msg_password2'] = 'Your passwords does not match!';

$lang['user_success_msg'] = 'User profile successfully updated.';
$lang['user_error_msg'] = 'The selected user profile could not be updated, unknown error!';

$lang['user_create_success_msg'] = 'User profile successfully created.';
$lang['user_create_error_msg'] = 'The user profile could not be created, unknown error!';

/*
 * Settings
 **********/
$lang['settings_yes'] = 'Yes';
$lang['settings_no'] = 'No';
$lang['settings_backend'] = 'Backend';
$lang['settings_frontend'] = 'Frontend';
$lang['settings_reset'] = 'Reset';
$lang['settings_msg_success'] = 'Settings updated successfully!';
$lang['settings_license_server_unavailable'] = 'Sorry, the License-Server is currently not available!';
$lang['settings_license_help'] = 'If you have any problems with your license or the activation process, <a href="mailto:pascal@pascal-bajorat.com"><strong>please contact us</strong></a>!';

$lang['settings_tab1'] = 'General';
$lang['settings_tab2'] = 'User Roles';
$lang['settings_tab3'] = 'Customization';
$lang['settings_tab4'] = 'System and Updates';
$lang['settings_general_h'] = 'General Settings';
$lang['settings_license_h'] = 'License';
$lang['settings_code_style'] = 'Code Style';
$lang['settings_editor_mode'] = 'Editor Mode';
$lang['settings_editor_mode_basic'] = 'Basic';
$lang['settings_editor_mode_standard'] = 'Standard';
$lang['settings_editor_mode_full'] = 'Full';
$lang['settings_disable_dashboard'] = 'Disable Dashboard';
$lang['settings_disable_login_animation'] = 'Disable Login-Animation';
$lang['settings_disable_lightbox'] = 'Disable Frontend Lightbox';
$lang['settings_disable_cache'] = 'Disable Cache-System';
$lang['settings_login_captcha'] = 'Login-Captcha';
$lang['settings_login_redirect'] = 'After Login redirect to';
$lang['settings_license_key'] = 'License Key / Item Purchase Code';
$lang['settings_license_key_help'] = 'Need help to find your Item Purchase Code?';
$lang['settings_ca_files'] = 'Can access Files menu';
$lang['settings_ca_developer'] = 'Can access Developer menu';
$lang['settings_ca_backup'] = 'Can access Backup menu';
$lang['settings_ca_user'] = 'Can edit other user profiles';
$lang['settings_ca_settings'] = 'Can access Settings menu';
$lang['settings_fe_color_1'] = 'Frontend Primary Color';
$lang['settings_fe_color_2'] = 'Frontend Secondary Color';
$lang['settings_software_name'] = 'Software Name';
$lang['settings_copyright'] = 'Copyright';
$lang['settings_login_logo'] = 'Login Logo (640 x 230 Pixel)';
$lang['settings_topbar_logo'] = 'Topbar Logo (88 x 88 Pixel)';
$lang['settings_login_background'] = 'Login Background';
$lang['settings_backend_background'] = 'Backend Background';
$lang['settings_custom_css'] = 'If you need a more flexible customization, you can add a CSS file named "%s" at this location: "%s". This file will automatically included by %s and you can inject your custom CSS code.';

$lang['update_installed'] = 'Installed Version';
$lang['update_available'] = 'Available Version';
$lang['update_last_check'] = 'Last Update-Check';
$lang['update_panel_h'] = 'Update available';
$lang['update_panel_note'] = 'Important Note';
$lang['update_panel_note_txt'] = 'Before you install this update, it is recommended to backup your database and all files on your webspace! While the update process is in progress please do not close this browser window!';
$lang['update_panel_install_btn'] = 'Install this update';
$lang['update_panel_successful'] = 'The update was installed successfully. <a href=\"%s\"><strong>Click here to complete the update!</strong></a>';
$lang['update_panel_failed'] = 'Update failed';
$lang['update_panel_uptodate'] = 'Your installation of %s is up to date.';
$lang['update_panel_update_message'] = 'There is a newer version available, it\'s recommended to install this update to v.%s';
$lang['update_panel_changelog_message'] = 'You can find more informations about this update in our <a href=\"%s\" target=\"_blank\">changelogs</a>, please read the informations about the new version before you start the update.';

$lang['backup_desc'] = 'Here you can clean, optimize and backup your database.';
$lang['backup_driver_error'] = 'Sorry, Backup and Database Optimization works only with the MySQL Database-Driver!';
$lang['backup_driver_error_zip'] = 'You have not installed the PHP ZZLIB library, without it some of the backup functions will fail!';
$lang['backup_btn_backup'] = 'Create a new Backup';
$lang['backup_btn_optimize'] = 'Optimize Database';
$lang['backup_path'] = 'Backup Path';
$lang['backup_msg_success'] = 'Backup successfully created!';
$lang['backup_msg_error'] = 'Could not create Backup!';
$lang['backup_msg_opt_success'] = 'Your database tables was repaired and optimized!';
$lang['backup_msg_opt_error'] = 'Your database could not be repaired or optimized!';

$lang['cache_h'] = 'Clean your Caches';
$lang['cache_desc'] = 'Over the time simpleCE create different files in your cache directories to speed up your website. Here you can clean your caches, simpleCE will automatically reinitialize all needed files on the next start up.';
$lang['cache_info'] = 'Cache Info';
$lang['cache_general_cache'] = 'General-Cache';
$lang['cache_image_cache'] = 'Image-Cache';
$lang['cache_update_cache'] = 'Update-Cache';
$lang['cache_clean_btn'] = 'Empty All Caches';
$lang['cache_success_msg'] = 'All caches successfully emptied.';

/*
 * Row
 **********/
$lang['row'] = 'Row';
$lang['row_add'] = 'Add a new Row';
$lang['row_delete'] = 'Delete this Row';

/*
 * Setup
 **********/
$lang['setup_js_warning'] = 'Please activate JavaScript in your Browser to use simpleCE and this installation script!';
$lang['setup_step1_h'] = 'Welcome to simpleCE';
$lang['setup_step1_welcome'] = 'Welcome to the five minutes setup of simpleCE v.2.2, please check the system requirements before you begin with the installation process:';
$lang['setup_step1_change_lang'] = 'Change the system language';
$lang['setup_step1_english'] = 'English';
$lang['setup_step1_german'] = 'German';
$lang['setup_step1_requirements'] = 'Server Requirements';
$lang['setup_step1_php'] = 'PHP-Version';
$lang['setup_step1_mysql'] = 'A MySQL 5.1 (or greater) Database is required';
$lang['setup_step1_curl'] = 'PHP cURL is required';
$lang['setup_step1_zzlib'] = 'PHP ZZIPlib is required';
$lang['setup_step1_info_h'] = 'Informations we need';
$lang['setup_step1_info2_h'] = 'Auto-Updater Requirements';
$lang['setup_step1_file_permissions'] = 'File Permissions';
$lang['setup_step1_check_error'] = 'Please solve the problems and not writable files or folders before you can start the installation!';
$lang['setup_step1_nextstep'] = 'Next Step';
$lang['setup_step1_check_again'] = 'Check again';
$lang['setup_step1_image_lib'] = 'Image manipulation library like GD2 or Imagick';
$lang['setup_step1_image_lib_error'] = 'Image manipulation library like GD2 or Imagick (you can not use thumbnails without it)';

$lang['setup_step2_h'] = 'Please configure your system';
$lang['setup_step2_desc'] = 'Please type in your User and Website credentials and also the access data for your Database:';
$lang['setup_step2_user_system'] = 'User and System';
$lang['setup_step2_siteurl'] = 'Site URL';
$lang['setup_step2_firstname'] = 'Admin Firstname';
$lang['setup_step2_surname'] = 'Admin Surname';
$lang['setup_step2_username'] = 'Admin Username';
$lang['setup_step2_password'] = 'Admin Password';
$lang['setup_step2_email'] = 'Admin Email';
$lang['setup_step2_db_config'] = 'Database Configuration';
$lang['setup_step2_db_driver'] = 'Database Driver';
$lang['setup_step2_db_recommended'] = 'recommended';
$lang['setup_step2_db_server'] = 'Database Server';
$lang['setup_step2_db_username'] = 'Database Username';
$lang['setup_step2_db_password'] = 'Database Password';
$lang['setup_step2_db_database'] = 'Databasename';
$lang['setup_step2_db_prefix'] = 'Table Prefix';
$lang['setup_step2_check_btn'] = 'confirm and check';
$lang['setup_step2_demo_data'] = 'Install Demo-Content (<strong class="red">works only with the simpleCE demo website!</strong>)';

$lang['setup_step3_h'] = 'Ready to install ...';
$lang['setup_step3_desc'] = 'Your configuration looks good and we are ready to install simpleCE on your server. simpleCE can now communicate with your database. If you are ready, time now to ...';
$lang['setup_step3_install_btn'] = 'Run the install';
$lang['setup_step3_wait'] = 'Please wait ...';
$lang['setup_step3_error_db_connect'] = 'Error establishing a database connection to \"%s\". This either means that the username and password information is incorrect or we can\'t contact the database server at \"%s\"!<br /><br />%s';
$lang['setup_step3_error_db'] = 'We were able to connect to the database server \"%s\" (which means your username and password is okay) but not able to select the database \"%s\", please check your settings!<br /><br />%s';

$lang['setup_step4_h'] = 'You are done!';
$lang['setup_step4_desc'] = 'Yeah, you are done - simpleCE has been installed!';

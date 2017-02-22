<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

if( defined('frontend') ) {
    $route['default_controller'] = "frontend/main";
} else {
    $route['default_controller'] = "simplece/login";
}

$route['404_override'] = '';

$route['setup'] = "setup/welcome";
$route['setup-data-check'] = 'setup/setup_data_check';
$route['setup-config'] = 'setup/setup_config';
$route['setup-database-structure'] = 'setup/setup_database_structure';
$route['setup-database'] = 'setup/setup_database';

$route['login'] = "simplece/login";
$route['logout'] = "simplece/logout";

$route['dashboard'] = 'simplece/dashboard';

$route['content'] = 'simplece/content';

$route['content/text/(:num)'] = 'simplece/text/$1';
$route['content/image/(:num)'] = 'simplece/image/$1';
$route['content/file/(:num)'] = 'simplece/file/$1';

$route['files'] = 'simplece/files_overview';
$route['files/edit-file'] = 'simplece/edit_file';

$route['user'] = 'simplece/user';
$route['user/(:num)'] = 'simplece/edit_user/$1';
$route['user/new'] = 'simplece/edit_user/new';
$route['user/del/(:num)'] = 'simplece/del_user/$1';

$route['developer'] = 'simplece/developer';
$route['backup'] = 'simplece/backup';
$route['reset-demo'] = 'simplece/reset_demo_data';

$route['settings'] = 'simplece/settings';

$route['ajax/cke-upload'] = 'ajax/cke_upload';
$route['ajax/update-text/(:num)'] = 'ajax/update_text_element/$1';
$route['ajax/add-row/(:num)/(:num)'] = 'ajax/add_row/$1/$2';
$route['ajax/del-row/(:num)/(:num)'] = 'ajax/del_row/$1/$2';
$route['ajax/move-row/(:num)'] = 'ajax/move_row/$1';
$route['ajax/update-check'] = 'ajax/update_check';
$route['ajax/install-update'] = 'ajax/install_update';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
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
| There are two reserved routes:
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

$route['default_controller'] = "pages_front";
$route['404_override'] = '';

/* custom routes */
$route['admin'] = 'admin/admin/index';
$route['admin/settings'] = 'admin/admin/settings';
$route['admin/(:any)'] = 'admin/$1'; // default route for all admin paths

/* front end routes */
$route['horses-for-sale'] = 'horses_front/index';
$route['horses-for-sale/request_info'] = 'horses_front/request_info';
$route['horses-for-sale/(:num)'] = 'horses_front/for_sale/$1';

$route['(:any)'] = 'pages_front/index/$1'; // default route for all front end paths



/* End of file routes.php */
/* Location: ./application/config/routes.php */
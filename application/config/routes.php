<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$adminURL = ADMIN_URL;

$adminURLWithoutSlash = str_replace('/', '', $adminURL);

$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*Authentication*/
$route[$adminURLWithoutSlash] = 'Login';
$route[$adminURL.'login/process'] = 'Login/loginProcess';
$route[$adminURL.'forget-password'] = 'Login/forgetPassword';
$route[$adminURL.'forget-password-process'] = 'Login/forgetPasswordProcess';
$route[$adminURL.'verify-otp/(:any)'] = 'Login/verifyOtp/$1';
$route[$adminURL.'varify-otp-process'] = 'Login/varifyOtpProcess';
$route[$adminURL.'new-password/(:any)'] = 'Login/newPassword/$1';
$route[$adminURL.'change-password-process'] = 'Login/changePasswordProcess';
$route[$adminURL.'logout'] = 'Login/logout';

/*Dashboard*/
$route[$adminURL.'dashboard'] = 'Dashboard';

/*Categories*/
$route[$adminURL.'categories'] = 'Category';
$route[$adminURL.'category/add'] = 'Category/addCategory';
$route[$adminURL.'category/add-process'] = 'Category/addCategoryProcess';
$route[$adminURL.'category/block/(:any)'] = 'Category/blockCategory/$1';
$route[$adminURL.'category/activate/(:any)'] = 'Category/activateCategory/$1';
$route[$adminURL.'category/edit/(:any)'] = 'Category/updateCategory/$1';
$route[$adminURL.'category/edit-process/(:any)'] = 'Category/updateCategoryProccess/$1';
/*Users*/
$route[$adminURL.'user/activate/(:any)'] = 'Admin/activateUser/$1';
$route[$adminURL.'user/block/(:any)'] = 'Admin/deactivateUser/$1';
/*Ad Post*/
$route[$adminURL.'post'] = 'Admin/listPosts';
$route[$adminURL.'post/block/(:any)'] = 'Admin/deactivatePost/$1';
$route[$adminURL.'post/activate/(:any)'] = 'Admin/activatePost/$1';
$route[$adminURL.'post/update-duration/(:any)'] = 'Admin/updateDuration/$1';
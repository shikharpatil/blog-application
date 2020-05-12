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
$route['login']='login';
$route['home']='home';
$route['files']='files';
$route['files/upload_files']='files/upload_files';
$route['files/sub_create']='files/sub_create';
$route['files/set_dir_path']='files/set_dir_path';
$route['home/upload_files']='home/upload_files';
$route['ajaxcall/get_post_versions']='ajaxcall/get_post_versions';
$route['ajaxcall/save_comment']='ajaxcall/save_comment';
$route['ajaxcall/get_comment_textarea']='ajaxcall/get_comment_textarea';
$route['ajaxcall/edit_comment']='ajaxcall/edit_comment';
$route['ajaxcall/cancel_comment']='ajaxcall/cancel_comment';
$route['ajaxcall/get_blog_list']='ajaxcall/get_blog_list';
$route['ajaxcall/get_post_lock_status']='ajaxcall/get_post_lock_status';
$route['register']="register";
$route['move']="move";
$route['copy']="copy";
$route['cron']="cron";
$route['login/verify_login']='login/verify_login';
$route['register/register_user']='register/register_user';
$route['user/save_blog']="user/save_blog";
$route['user/logout']="user/logout";
$route['user/upload_image']='user/upload_image';
// $route['user/get_blogs/(:num)']='user/get_blogs/$1';
$route['user/update_blog']='user/update_blog';
$route['search/do_search']='search/do_search';
$route['user/save_comment']="user/save_comment";
$route['user/delete_blog/(:num)']='user/delete_blog/$1';
$route['user/get_versions/(:num)/(:num)']='user/get_versions/$1/$2';
$route['user/get_next_versions/(:num)/(:num)']='user/get_next_versions/$1/$2';
// $route['user/get_textarea/(:num)/(:num)']='user/get_textarea/$1/$2';
// $route['user/logout']='user/logout';
$route['(:any)']='user/check_user/$1';
$route['(:any)/(:any)']='user/open_blog/$1/$2';

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

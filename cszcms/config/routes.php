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
|	http://codeigniter.com/user_guide/general/routing.html
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

$route['admin'] = "admin/admin";
$route['admin/login'] = "admin/admin/login";
$route['admin/login/error'] = "admin/admin/login";
$route['admin/login/check'] = "admin/admin/loginCheck";
$route['admin/logout'] = "admin/admin/logout";

$route['admin/users'] = "admin/users";
$route['admin/users/new'] = "admin/users/addUser";
$route['admin/users/new/add'] = "admin/users/confirm";
$route['admin/users/delete'] = "admin/users/delete";
$route['admin/users/delete/(:any)'] = "admin/users/delete";
$route['admin/users/edit'] = "admin/users/editUser";
$route['admin/users/edit/(:any)'] = "admin/users/editUser";
$route['admin/users/edited/(:any)'] = "admin/users/edited";
$route['admin/users/(:any)'] = "admin/users";
$route['admin/user/forgot'] = 'admin/users/forgot';
$route['admin/reset/(:any)'] = 'admin/users/getPassword';
$route['admin/settings'] = "admin/admin/settings";
$route['admin/settings/update'] = "admin/admin/updateSettings";
$route['admin/social'] = "admin/admin/social";
$route['admin/social/update'] = "admin/admin/updateSocial";
$route['admin/navigation'] = "admin/navigation";
$route['admin/navigation/save'] = "admin/navigation/saveNav";
$route['admin/navigation/new'] = "admin/navigation/newNav";
$route['admin/navigation/insert'] = "admin/navigation/insert";
$route['admin/navigation/edit'] = "admin/navigation/editNav";
$route['admin/navigation/edit/(:any)'] = "admin/navigation/editNav";
$route['admin/navigation/delete'] = "admin/navigation/deleteNav";
$route['admin/navigation/delete/(:any)'] = "admin/navigation/deleteNav";
$route['admin/navigation/update/(:any)'] = "admin/navigation/update";
$route['admin/navigation/(:any)'] = "admin/navigation";
$route['admin/lang'] = "admin/languages";
$route['admin/lang/new'] = "admin/languages/addLang";
$route['admin/lang/insert'] = "admin/languages/insert";
$route['admin/lang/delete'] = "admin/languages/delete";
$route['admin/lang/delete/(:any)'] = "admin/languages/delete";
$route['admin/lang/edit'] = "admin/languages/editLang";
$route['admin/lang/edit/(:any)'] = "admin/languages/editLang";
$route['admin/lang/edited/(:any)'] = "admin/languages/edited";
$route['admin/lang/(:any)'] = "admin/languages";
$route['admin/pages'] = "admin/pages";
$route['admin/pages/new'] = "admin/pages/addPages";
$route['admin/pages/insert'] = "admin/pages/insert";
$route['admin/pages/delete'] = "admin/pages/delete";
$route['admin/pages/delete/(:any)'] = "admin/pages/delete";
$route['admin/pages/edit'] = "admin/pages/editPages";
$route['admin/pages/edit/(:any)'] = "admin/pages/editPages";
$route['admin/pages/edited/(:any)'] = "admin/pages/edited";
$route['admin/pages/(:any)'] = "admin/pages";
$route['admin/uploadindex'] = "admin/admin/uploadIndex";
$route['admin/uploadindex/(:any)'] = "admin/admin/uploadIndex";
$route['admin/fileupload'] = "admin/admin/filesUpload";
$route['admin/filehtmlupload'] = "admin/admin/htmlUpload";
$route['admin/uploadindex_save'] = "admin/admin/uploadIndexSave";
$route['admin/forms'] = "admin/forms";
$route['admin/forms/new'] = "admin/forms/addForms";
$route['admin/forms/insert'] = "admin/forms/insert";
$route['admin/forms/delete/(:any)'] = "admin/forms/delete";
$route['admin/forms/delete'] = "admin/forms/delete";
$route['admin/forms/edit/(:any)'] = "admin/forms/editForms";
$route['admin/forms/edit'] = "admin/forms/editForms";
$route['admin/forms/edited/(:any)'] = "admin/forms/edited";
$route['admin/forms/view'] = "admin/forms/viewForm";
$route['admin/forms/view/(:any)'] = "admin/forms/viewForm";
$route['admin/forms/view/(:any)/(:any)'] = "admin/forms/viewForm";
$route['admin/forms/view/delete'] = "admin/forms/deleteViewData";
$route['admin/forms/view/(:any)/delete'] = "admin/forms/deleteViewData";
$route['admin/forms/view/(:any)/delete/(:any)'] = "admin/forms/deleteViewData";
$route['admin/forms/(:any)'] = "admin/forms";
$route['admin/upgrade'] = "admin/upgrade";
$route['admin/upgrade/download'] = "admin/upgrade/download";
$route['admin/upgrade/optimize'] = "admin/upgrade/dbOptimize";
$route['admin/upgrade/backup'] = "admin/upgrade/dbBackup";
$route['admin/upgrade/clearAllCache'] = "admin/upgrade/clearAllCache";
$route['admin/upgrade/(:any)'] = "admin/upgrade";
$route['admin/linkstats'] = "admin/linkstats";
$route['admin/linkstats/view'] = "admin/linkstats/view";
$route['admin/linkstats/view/(:any)'] = "admin/linkstats/view";
$route['admin/linkstats/view/(:any)/(:any)'] = "admin/linkstats/view";
$route['admin/linkstats/deleteurl/(:any)'] = "admin/linkstats/deleteByURL";
$route['admin/linkstats/deleteurl'] = "admin/linkstats/deleteByURL";
$route['admin/linkstats/deleteid/(:any)'] = "admin/linkstats/deleteByID";
$route['admin/linkstats/deleteid'] = "admin/linkstats/deleteByID";
$route['admin/linkstats/deleteindexurl'] = "admin/linkstats/deleteIndexByURL";
$route['admin/linkstats/deleteviewid'] = "admin/linkstats/deleteViewByID";
$route['admin/linkstats/(:any)'] = "admin/linkstats";
$route['admin/genlabel'] = "admin/General_label";
$route['admin/genlabel/edit/(:any)'] = "admin/General_label/edit";
$route['admin/genlabel/edit'] = "admin/General_label/edit";
$route['admin/genlabel/updated/(:any)'] = "admin/General_label/updated";
$route['admin/genlabel/synclang'] = "admin/General_label/syncLang";
$route['admin/genlabel/(:any)'] = "admin/General_label";

$route['member'] = 'Member';
$route['member/login'] = 'Member/login';
$route['member/login/check'] = 'Member/loginCheck';
$route['member/logout'] = 'Member/logout';
$route['member/register'] = 'Member/registMember';
$route['member/register/save'] = 'Member/saveMember';
$route['member/confirm/(:any)'] = 'Member/confirmedMember';
$route['member/edit'] = 'Member/editMember';
$route['member/edit/save'] = 'Member/saveEditMember';
$route['member/forgot'] = 'Member/forgot';
$route['member/reset/(:any)'] = 'Member/getPassword';
$route['member/(:any)'] = 'Member';

$route['formsaction/(:any)'] = 'formsaction';
$route['formsaction'] = 'formsaction';
$route['linkstats/(:any)'] = 'linkstats';
$route['linkstats'] = 'linkstats';
$route['lang/(:any)'] = "home/setLang";
$route['default_controller'] = 'home';
$route['(.+)'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
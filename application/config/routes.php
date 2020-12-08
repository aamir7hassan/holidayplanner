<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['default_controller'] = 'login';
	$route['404_override'] = '';
	$route['translate_uri_dashes'] = TRUE;

	$route['logout'] = 'login/logout';
	$route['admin/reset-password'] = "login/reset_password";

	/********** ADMIN **********/
	$route['admin/categories'] = 'admin/dashboard/categories';
	$route['admin/categories/ajax'] = 'admin/dashboard/ajax';
	$route['admin/staff'] = 'admin/dashboard/staff';
	$route['admin/objekte'] = 'admin/dashboard/objekte';
	$route['admin/settings'] = "admin/dashboard/settings";
	$route['admin/notification'] = "admin/dashboard/notification";
	$route['admin/free-staff'] = "admin/dashboard/free_staff";
	$route['admin'] = 'admin/dashboard/index';
	$route['admin/antrag-auf-mehrarbeit'] = 'admin/dashboard/antrag_auf_mehrarbeit';
	$route['admin/antrag-auf-mehrarbeit/(:any)'] = 'admin/dashboard/antrag_auf_mehrarbeit/$1';
	$route['admin/checklisten/detail-view/(:any)']='admin/checklists/detail_view/$1';
	$route['admin/managers'] = 'admin/dashboard/managers';
	$route['admin/objektmanagers'] = 'admin/dashboard/objektmanagers';
	$route['admin/public-holidays'] = 'admin/dashboard/public_holidays';

    /********Checklist**************/
	$route['admin/checklisten/(:any)'] = 'admin/checklists/filter/$1';
	$route['supervisor/checklisten/detail-view/(:any)']='supervisor/checklisten/detail_view/$1';
	$route['admin/checklisten']='admin/checklists/checklisten';
	//$route['admin/checklisten/erstellen'] ='admin/checklists/index';
	//$route['admin/cl/cl_uebersicht']='admin/checklists/overview';
	$route['admin/checklists_detail/(:any)']='admin/checklists/detail/$1';
	$route['supervisor/checklisten/(:any)']='supervisor/checklisten/filter/$1';
	$route['supervisor/checklisten']='supervisor/checklisten/index';

	/********** SUPERVISOR ***********/	
	$route['supervisor'] = 'supervisor/dashboard/index';
	$route['supervisor/attendance'] = 'supervisor/dashboard/attendance';
	$route['supervisor/antrag-auf-mehrarbeit'] ='supervisor/dashboard/Antrag_auf_Mehrarbeit';
	$route['supervisor/antrag-auf-mehrarbeit/(:any)'] ='supervisor/dashboard/Antrag_auf_Mehrarbeit/$1';
	$route['supervisor/add-antrag-auf-mehrarbeit'] = 'supervisor/dashboard/add_antrag_auf_mehrarbeit';
	$route['supervisor/processFormular'] = 'supervisor/dashboard/processFormular';
	$route['supervisor/list-staff'] =  'supervisor/dashboard/list_staff';
	$route['supervisor/add-staff'] =  'supervisor/dashboard/add_staff';
	$route['supervisor/edit-staff/(:num)'] =  'supervisor/dashboard/edit_staff/$1';
	$route['supervisor/public-holidays'] = 'supervisor/dashboard/public_holidays';
	
	/********** MANAGERS ************/
	$route['manager'] = 'manager/dashboard/index';
	$route['manager/antrag-auf-mehrarbeit/(:any)'] = 'manager/dashboard/antrag_auf_mehrarbeit/$1';

	/******** Objekt Managers *****/
	$route['objektmanager'] = 'objektmanager/dashboard/index';

	/******** Kalk *****/
	$route['kalk'] = 'kalk/dashboard/index';
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

// Normal routing rule
// $route['your-own-routing-name'] = 'class/method';
// Routing rule with designated parameter
// $route['your-own-routing-name/(:num)'] = 'class/method/$1';
// $route['your-own-routing-name/(:any)'] = 'class/method/';

// Login
$route['login']  = 'user/user_login';
$route['logout'] = 'user/user_logout';
$route['change_password'] = 'user/user_change_password';

// User
$route['user_profile'] = 'user/user_profile';

// Admin routing rules
$route['admin_dashboard'] 	 		= 'admin/admin_dashboard';
$route['admin_users'] 	  	 		= 'user/users';
$route['admin_history']	  	 		= 'admin/admin_history';
$route['admin_security']  	 		= 'admin/admin_security';
$route['user_registration']	 		= 'user/user_register';
$route['rooms']				 		= 'room/rooms';
$route['room_create']		 		= 'room/room_create';
$route['vocational_programs']		= 'vocational_program/vocational_programs';
$route['vocational_program_create'] = 'vocational_program/vocational_program_create';
$route['subjects']					= 'subject/subjects';
$route['subject_create']			= 'subject/subject_create';
$route['batch_year']				= 'batch_year/current_batch_year';
$route['students']					= 'student/students';
$route['student_registration']		= 'student/student_registration';
$route['register_student']			= 'student/student_enrollment_registration';
$route['register_student/(:num)']	= 'student/student_enrollment_registration/$1';
$route['register_students']			= 'student/register_students';
$route['subject_assigning']			= 'subject/subject_assigning';
$route['attendance_report']			= 'admin/attendance_report';
$route['student_import_registration']='student/student_import_registration';


// Faculty routing rules
$route['faculty_dashboard'] 		= 'faculty/faculty_dashboard';
$route['faculty_assigned_subjects']	= 'faculty/faculty_assigned_subjects';
$route['faculty/faculty_attendance/(:num)'] = 'faculty/faculty_attendance/$1';//change logs 10-1-2018
$route['faculty_attendance_records']= 'faculty/faculty_attendance_records';

// Unauthorized Error page
$route['unauthorized_access']		= 'faculty/unauthorized_access';

// Error
$route['err'] = 'user/user_err';

$route['default_controller'] = 'user/user_login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

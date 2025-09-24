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
|	https://codeigniter.com/userguide3/general/routing.html
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

// login & register module module 
$route['register'] = 'welcome/RegisterView';
$route['company-registeration-data'] = 'welcome/comapnyRegisterationData';
$route['verify-account'] = 'welcome/VerifyAccount';
$route['verif-account-data'] = 'welcome/VerifyAccountData';
$route['resend-verification-email'] = 'welcome/resendVerificationEmail';
$route['user-registeration-data'] = 'welcome/userRegistersationData';
$route['forgot-password'] = 'welcome/forgotpassword';
$route['forgot-password-data'] = 'welcome/forgotpasswordData';
$route['reset-password'] = 'welcome/resetPassword';
$route['reset-password-data'] = 'welcome/resetPasswordData';
$route['login-data'] = 'welcome/loginData';

//dashboards
$route['company-dashboard'] = 'welcome/companyDashboard';


//manage workforce company
//--maage skill
$route['manage-workforce-skill']='workforce/ManageWorkforceSkill';
$route['add-skill-data']='workforce/addSkillData';
$route['delet-skill/:any']='workforce/DeleteSkill';
$route['update-skill-data/:any']='workforce/UpdateSkillData';
//--add workforce
$route['add-workforce']='workforce/addWorkforce';
$route['add-skill-data-ajax']='workforce/addSkillDataAjax';
$route['add-work-force-data']='workforce/addWorkForceData';
$route['all-workforce']='workforce/allWorkforce';
$route['delete-person/:any']='workforce/DeletePerson';
$route['edit-work-force/:any']='workforce/editWorkForce';


//manage equipment company
//--manage category
$route['manage-category']='equipment/ManageCategory';
$route['equipment-category-data']='equipment/CategoryData';
$route['delete-category/:any']='equipment/deletCategory';
$route['update-category-data/:any']='equipment/CategoryUpdateData';
//--add equipment
$route['add-equipment']='equipment/AddEquipment';
$route['add-equipment-data']='equipment/AddEquipmentData';
$route['add-equipment-category-jax']='equipment/AddEquipmentAjaxData';
//--all equipment
$route['all-equipment']='equipment/AllEquipment';
$route['delet-equipment/:any']='equipment/DeleteEquipment';
$route['edit-equipment/:any']='equipment/EditEquipment';
$route['edit-equipment-data/:any']='equipment/UpdateEquipmentData';


//manage project company
//--manage category
$route['project-category']='project/ProjectCategory';
$route['project-cat-data']='project/ProjectCategoryData';
$route['delet-project-cat/:any']='project/ProjectCategoryDeletData';
$route['update-project-category-data/:any']='project/ProjectCategoryEditData';
//--add project
$route['add-project']='project/AddProject';
$route['add-project-general-data']='project/AddProjectGeneralData'; // ajax first step(General data)
$route['add-project-workforce']='project/AddProjecWorkforce'; // ajax second step(workforce data)
$route['remove-project-workforce']='project/removeWorkforceFromProject'; // ajax second step(workforce removal)
$route['add-project-equipment']='project/addProjectEquipment'; // ajax add project equipment
$route['remove-project-equipment']='project/RemoveProjectEquipment'; // ajax add project equipment
$route['move-to-step3']='project/MovetoStepThree'; // ajax Move to step 3
$route['assign-equipment-employee']='project/assignEquipmenttoEmployee'; // ajax assign equipment to employee
$route['remove-assigned-equipment']='project/removeAssignEquipmenttoEmployee'; // ajax remove assigned equipment to employee
$route['mark-project-as-inprogress']='project/MarkInProgressProject'; 
//--all projects
$route['all-projects']='project/AllProjects';
$route['delete-project/:any']='project/DeletProject';

$route['login-data'] = 'welcome/LoginData';

//test email
$route['test-mail']='welcome/TestMail'; 


$route['logout'] = 'welcome/LogOut';
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
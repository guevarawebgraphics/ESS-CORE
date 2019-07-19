<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { // root if the user is login
    if (Auth::guest())
    {
        return view('auth.login');  
    }
    else
    {   
            if(auth()->user()->ischange == 1)
            {
                //Route::get('/myprofile/settings', 'MyProfileController@settings');
                return view('admin_modules.myprofile.changepassword');
            }
            else
            {
                if(auth()->user()->ischange == 1)
            {
                //Route::get('/myprofile/settings', 'MyProfileController@settings');
                return view('admin_modules.myprofile.changepassword');
            }
            else
            {
                if(auth()->user()->user_type_id === 1){
                    $employers = DB::table('employer')->count();
                    return view('dashboard', compact('employers')); 
                }
                $content_status ="1"; // content_status 
                $content = DB::table('employercontent')   //for showing employer's content
                                ->orderBy('created_at')
                                ->where('account_id','=',auth()->user()->employer_id)
                                ->where('content_status','=',$content_status)
                                ->get(); 
                                
                // count number of content posted
                $count = DB::table('employercontent')
                                ->where('account_id','=',auth()->user()
                                ->employer_id)
                                ->count();  

                // count number of employees
                $count_employee = DB::table('employee')
                                ->where('employer_id','=',auth()->user()->employer_id)
                                ->count();
    
                $count_my_employeer = DB::table('employer_and_employee')
                                ->where('employee_id','=',auth()->user()->employee_id)
                                ->count();
    
                return view('dashboard', compact('content','count','count_employee','count_my_employeer'));
            
            }
            
        }
        
        //return "ASA";          
    }
});

Auth::routes();
/*Guard route*/
Route::get('/logout', function(){
    return abort(404);
});
//Route::get('/home', 'HomeController@index')->name('home');

//Manage Users
Route::get('/manageuser/create', 'ManageUserController@createuser');
Route::get('/manageuser/create/refresh', 'ManageUserController@refreshtable_user')->name('refreshtable_user');
Route::get('/manageuser/manage', 'ManageUserController@manageusertypes');
Route::get('/manageuser/manage/refresh', 'ManageUserController@refreshtable_usertype')->name('refreshtable_usertype');
Route::get('/manageuser/showmodule', 'ManageUserController@show_module')->name('showmodule');
Route::get('/manageuser/load_usertype', 'ManageUserController@load_usertype')->name('load_usertype');
Route::post('/manageuser/createusertype_post', 'ManageUserController@createusertype_post')->name('usertype_post');
Route::post('/manageuser/updatemoduleaccess', 'ManageUserController@update_module_access')->name('updatemoduleaccess');
Route::post('/manageuser/updateusertype_post', 'ManageUserController@updateusertype_post')->name('updateusertype_post');
Route::post('/manageuser/deleteusertype_post', 'ManageUserController@deleteusertype_post')->name('deleteusertype_post');
Route::post('/manageuser/updateuser_post', 'Auth\\RegisterController@updateuser_post')->name('updateuser_post');
Route::post('/manageuser/deleteuser_post', 'ManageUserController@deleteuser_post')->name('deleteuser_post');
Route::get('/manageuser/load_employer', 'ManageUserController@loademployer')->name('loademployer');
Route::get('/manageuser/checkusername', 'Auth\\RegisterController@checkusername')->name('checkusername');
Route::post('/manageuser/create/reset_password', 'Auth\\RegisterController@reset_password')->name('resetpassword');
Route::get('/manageuser/generate', 'ManageUserController@ESSIDGenerate');
Route::patch('/manageuser/UpdateAccountStatus/{id}', 'ManageUserController@UpdateAccountStatus');

//My Profile
Route::get('/myprofile/settings', 'MyProfileController@settings');
Route::get('/myprofile/changepassword', 'MyProfileController@changepassword');
Route::get('/myprofile/systemlogs', 'MyProfileController@systemlogs');
Route::get('/myprofile/settings/info', 'MyProfileController@settings_info')->name('settingsinfo');
Route::post('/myprofile/settingsupdate_post', 'MyProfileController@settingsupdate_post')->name('settingsupdate_post');
Route::get('/myprofile/changepassword_prev', 'MyProfileController@checkcurpass')->name('changepassword_prev');
Route::post('/myprofile/changepassword_post', 'MyProfileController@changepassword_post')->name('changepassword_post');


/*Route Config For Account*/
Route::get('/Account', 'AccountController@index')->name('Account.index');
Route::get('/Account/get_all_account', 'AccountController@get_all_account');
Route::get('/Account/create', 'AccountController@create')->name('Account.create');
Route::get('/Account/edit/{id}', 'AccountController@edit')->name('Account.edit');
Route::get('/Account/get_province', 'AccountController@get_province')->name('Account.get_province');
Route::get('/Account/get_citytown/{provCode}', 'AccountController@get_citytown')->name('Account.get_citytown');
Route::get('/Account/get_barangay/{citymunCode}', 'AccountController@get_barangay')->name('Account.get_barangay');
Route::get('/Account/get_user_type', 'AccountController@get_user_type')->name('Account.get_user_type');
Route::post('/Account/destroy', 'AccountController@destroy')->name('Account.destroy');
Route::patch('/Account/{id}', 'AccountController@update')->name('Account.update');
Route::patch('/Account/UpdateAccountStatus/{id}', 'AccountController@UpdateAccountStatus')->name('Account.UpdateAccountStatus');
Route::post('/Account', 'AccountController@store')->name('Account');
Route::get('/Account/get_all_employer', 'AccountController@get_all_employer')->name('Account');
Route::get('/Account/Activation/{id}', 'AccountController@UserActivation');
Route::get('/Account/Activation', 'AccountController@ActivationPage');
Route::post('/Account/ActivateUser', 'AccountController@ActivateUser');
Route::get('/Account/edit', function(){
    abort(404);
});

/*Route Config For Notification*/
Route::get('/Notification', 'NotificationController@index')->name('Notification.index');
Route::get('/Notification/get_all_notifications', 'NotificationController@get_all_notifications');
Route::post('/Notification/store_notification', 'NotificationController@store_notification');
Route::get('/Notification/edit_notification', 'NotificationController@edit_notification');
Route::post('/Notification/update_notification/{id}', 'NotificationController@update_notification');
Route::post('/Notification/destroy_notification', 'NotificationController@destroy_notification');

/*Route Config For Template*/
Route::get('/Template', 'TemplateController@index')->name('Template.index'); 
Route::get('/Template/get_all_template', 'TemplateController@get_all_template');
Route::get('/Template/edit_template', 'TemplateController@edit_template');
Route::post('/Template/update_template/{id}', 'TemplateController@update_template');
Route::post('/Template/store_template', 'TemplateController@store_template');
Route::post('/Template/destroy_template', 'TemplateController@destroy_template');

/*Route Config For Announcement*/
Route::get('/Announcement', 'AnnouncementController@index')->name('Announcement.index');
Route::get('/Announcement/get_all_announcement', 'AnnouncementController@get_all_announcement');
Route::get('/Announcement/get_all_announcement_to_notification', 'Announcementcontroller@get_all_announcement_to_notification');
Route::get('/Announcement/edit_announcement', 'AnnouncementController@edit_announcement');
Route::post('/Announcement/store_announcement', 'AnnouncementController@store_announcement');
Route::post('/Announcement/update_announcement/{id}', 'AnnouncementController@update_announcement');
Route::post('/Announcement/destroy_announcement', 'AnnouncementController@destroy_announcement');
Route::post('/Announcement/update_announcement_status', 'AnnouncementController@update_announcement_status');
Route::post('/Announcement/update_notification_show', 'AnnouncementController@update_notification_show');
Route::get('/Announcement/get_notification_show', 'AnnouncementController@get_notification_show');


////// EMPLOYER

//Employees Enrollment
Route::get('/enrollemployee', 'EmployeesEnrollmentController@index')->name('enrollemployee');
Route::get('/enrollemployee/getcity/{provCode}', 'EmployeesEnrollmentController@get_citytown');
Route::get('/enrollemployee/getbarangay/{citymunCode}', 'EmployeesEnrollmentController@get_barangay');
Route::get('/enrollemployee/getprovince', 'EmployeesEnrollmentController@get_province');
Route::get('/enrollemployee/encode', 'EmployeesEnrollmentController@encode');
Route::get('/enrollemployee/upload', 'EmployeesEnrollmentController@upload');
Route::post('/enrollemployee/encode/post', 'EmployeesEnrollmentController@encode_post');
Route::get('/enrollemployee/searchemployee', 'EmployeesEnrollmentController@search_existing_employee');
Route::get('/enrollemployee/edit/{id}', 'EmployeesEnrollmentController@edit_encode');
Route::get('/enrollemployee/refresh_table_employee', 'EmployeesEnrollmentController@refresh_table_employee');
Route::patch('/enrollemployee/update_employee/{id}', 'EmployeesEnrollmentController@update_employee');
Route::patch('/enrollemployee/UpdateAccountStatus/{id}', 'EmployeesEnrollmentController@UpdateAccountStatus');
Route::post('/enrollemployee/upload_employees', 'EmployeesEnrollmentController@upload_employees');

//Employer Content
Route::get('/employercontent/manage', 'EmployerContentController@manage');
Route::get('/employercontent/manage/refresh', 'EmployerContentController@refresh_manage')->name('refreshmanage');
Route::get('/employercontent/edit', 'EmployerContentController@edit_content')->name('editemployercontent');
Route::post('/employercontent/create', 'EmployerContentController@create_employercontent')->name('createemployercontent');
Route::post('/employercontent/edit/post', 'EmployerContentController@update_content')->name('updateemployercontent');
Route::post('/employercontent/delete', 'EmployerContentController@delete_content')->name('deleteemployercontent');
Route::post('/employercontent/post_content', 'EmployerContentController@post_content')->name('postemployercontent');


//Payroll Management
Route::get('/payrollmanagement/upload', 'PayrollManagementController@upload');
Route::get('/payrollmanagement/view', 'PayrollManagementController@view');
Route::get('/payrollmanagement/get_payroll_register', 'PayrollManagementController@get_payroll_register');
Route::post('/payrollmanagement/upload_payregister', 'PayrollManagementController@upload_payregister');
Route::post('/payrollmanagement/post_payroll_register', 'PayrollManagementController@post_payroll_register');
Route::post('/ProfilePicture/UpdatePicture', 'ProfilePictureController@UpdatePicture');


/**Upload Profile Picture */
Route::post('/ProfilePicture/UploadPicture', 'ProfilePictureController@UploadPicture');
Route::get('/ProfilePicture/get_profile_picture', 'ProfilePictureController@get_profile_picture');
Route::get('/ProfilePicture/get_profile_picture_via_search_employee', 'ProfilePictureController@get_profile_picture_via_search_employee');


//Cash Advance
Route::get('/cashadvance', 'CashAdvanceController@index');


//E wallet
Route::get('/ewallet', 'EWalletController@index');

//Financial Calendar
Route::get('/financialcalendar', 'FinancialCalendarController@index');

//ICredit
Route::get('/icredit', 'iCreditController@index');

//Payslips
Route::get('/payslips', 'PayslipsController@index')->name('payslips'); 
Route::get('/payslips/get', 'PayslipsController@getPayslipsList')->name('getPayslipsList');
Route::get('/payslips/view/{id}', 'PayslipsController@viewpayslips')->name('viewpayslips');
Route::post('/payslips/filter', 'PayslipsController@filter')->name('filter'); 
Route::get('/payslips/view', function(){
    abort(404);
});
//Time Attendance
Route::get('/timeattendance', 'TimeAttendanceController@index');


Route::get('/error', function () { // for no access
   
    return view('welcome');
    
});

Route::get('/email', function() {
    return view('Email.employee_email');
});



Route::get('/Testsocket', function() {
    return view('Testsocket');
});
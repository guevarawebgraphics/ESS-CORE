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
            return view('dashboard'); 
        }
        
        //return "ASA";          
    }
});

Auth::routes();

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

/*Route Config For Notification*/
Route::get('/Notification', 'NotificationController@index')->name('Notification.index');
Route::get('/Notification/get_all_notifications', 'NotificationController@get_all_notifications');
Route::post('/Notification/store_notification', 'NotificationController@store_notification');
Route::get('/Notification/edit_notification', 'NotificationController@edit_notification');
Route::post('/Notification/update_notification/{id}', 'NotificationController@update_notification');
Route::post('/Notification/destroy_notification', 'NotificationController@destroy_notification');



Route::get('/error', function () { // for no access
   
    return view('welcome');
    
});

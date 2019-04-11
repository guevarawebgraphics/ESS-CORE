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

Route::get('/', function () {
    
    //Check if The User is Already LoggedIn
    if (!Auth::check()) {
        //return 'Hello World';
        return view('auth.login');
    }
    else {
        // abort(404);
        return redirect()->route('home');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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

//My Profile
Route::get('/myprofile/settings', 'MyProfileController@settings');
Route::get('/myprofile/changepassword', 'MyProfileController@changepassword');
Route::get('/myprofile/systemlogs', 'MyProfileController@systemlogs');


/*Route Config For Account*/
Route::get('/Account', 'AccountController@index')->name('Account.index');
Route::get('/Account/create', 'AccountController@create')->name('Account.create');
Route::get('/Account/edit/{account}', 'AccountController@edit')->name('Account.edit');
Route::get('/Account/get_province', 'AccountController@get_province')->name('Account.get_province');
Route::get('/Account/get_citytown/{provCode}', 'AccountController@get_citytown')->name('Account.get_citytown');
Route::get('/Account/get_barangay/{citymunCode}', 'AccountController@get_barangay')->name('Account.get_barangay');
Route::get('/Account/get_user_type', 'AccountController@get_user_type')->name('Account.get_user_type');
Route::delete('/Account/{account}', 'AccountController@destroy')->name('Account.destroy');
Route::patch('/Account/{account}', 'AccountController@update')->name('Account.update');
Route::post('/Account', 'AccountController@store')->name('Account');
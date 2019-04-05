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
    return view('welcome');
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


/*Route Config For Account*/
Route::get('/Account', 'AccountController@index')->name('Account.index');
Route::get('/Account/create', 'AccountController@create')->name('Account.create');
Route::post('/Account', 'AccountController@store')->name('Account');
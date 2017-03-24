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

Route::get('/login', 'LoginController@login_show');
Route::post('/login', 'LoginController@login');

Route::group(['middleware'=>'auth:admin'],function(){
	Route::get('/logout', 'LoginController@logout');
	
	Route::get('/', "Index@index");

	Route::get('/test/{id}', "Index@test");
	
	Route::get('/adm/list',"AdminController@index");
	Route::get('/adm/add',"AdminController@add_show");
	Route::post('/adm/add',"AdminController@add_exec");
	Route::get('/adm/edit/{id}',"AdminController@edit_show");
	Route::post('/adm/edit',"AdminController@edit_exec");
	Route::post('/adm/del',"AdminController@del");

	Route::get('/role/add',"RoleController@add");

	Route::get('/home', 'HomeController@index');

	Route::get('/permission/index','PermissionController@index');
	Route::get('/permission/add','PermissionController@add_show');
	Route::post('/permission/add','PermissionController@add');
});
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

Route::get('/login', 'LoginController@login_show')->name('login');
Route::post('/login', 'LoginController@login');

Route::group(['middleware'=>['auth:admin','menuPermission']],function(){
	Route::get('/logout', 'LoginController@logout');
	
	Route::get('/', "Index@index");

	Route::get('/test/{id}', "Index@test");
	
	//管理员 相关
	Route::get('/adm/index',"AdminController@index");
	Route::get('/adm/add',"AdminController@add_show");
	Route::post('/adm/add',"AdminController@add_exec");
	Route::get('/adm/edit/{id}',"AdminController@edit_show");
	Route::post('/adm/edit',"AdminController@edit_exec");
	Route::post('/adm/del',"AdminController@del");

	//角色 相关
	Route::get('/role/index',"RoleController@index");
	Route::get('/role/add',"RoleController@add_show");
	Route::post('/role/add',"RoleController@add_exec");
	Route::get('/role/edit/{id}',"RoleController@edit_show");
	Route::post('/role/edit',"RoleController@edit_exec");
	Route::post('/role/upd_status',"RoleController@upd_status");
	Route::post('/role/del',"RoleController@del");
	Route::get('/role/permission/{id}',"RoleController@permission");

	//权限 相关
	Route::get('/permission/index',"PermissionController@index");
	Route::get('/permission/add',"PermissionController@add_show");
	Route::post('/permission/add',"PermissionController@add_exec");
	Route::get('/permission/edit/{id}',"PermissionController@edit_show");
	Route::post('/permission/edit',"PermissionController@edit_exec");
	Route::post('/permission/upd_status',"PermissionController@upd_status");
	Route::post('/permission/del',"PermissionController@del");
});
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

Route::get('/', 'HomeController@index');
Auth::routes();

Route::group(['middleware'=>'auth'], function() {

	Route::get('/role','RoleController@index');

	Route::post('/role/store','RoleController@store');

	Route::post('/role/destroy','RoleController@destroy');

	Route::get('/role/edit','RoleController@edit');

	Route::post('/role/update','RoleController@update');

	Route::get('/users','UsersController@index');

	Route::post('/users/destroy','UsersController@destroy');

	Route::get('/users/edit','UsersController@edit');

	Route::post('/users/update','UsersController@update');

	Route::get('users/roles_details', 'UsersController@roles_details');

	Route::get('/permission','PermissionsController@index');

	Route::post('/permission/store','PermissionsController@store');

	Route::post('/permission/destroy','PermissionsController@destroy');

	Route::get('/permission/edit','PermissionsController@edit');

	Route::post('/permission/update','PermissionsController@update');
});


Route::get('permission/get_datatable','PermissionsController@get_datatable');
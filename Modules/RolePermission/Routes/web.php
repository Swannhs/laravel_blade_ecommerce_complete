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

use Illuminate\Support\Facades\Route;

Route::prefix('hr')->group(function() {
Route::prefix('role-permission')->group(function() {
Route::name('permission.')->group(function() {
	Route::middleware('permission')->group(function(){
		Route::resource('roles', 'RoleController')->except('destroy');
		Route::get('/hr/role-permission/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy')->middleware('prohibited_demo_mode');
        Route::resource('permissions', 'PermissionController');
	});
});
});
});

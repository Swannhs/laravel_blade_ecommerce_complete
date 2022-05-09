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

Route::middleware(['admin','permission'])->prefix('useractivitylog')->group(function() {
    Route::get('/', 'UserActivityLogController@index')->name('activity_log');
    Route::get('/get-activity-data', 'UserActivityLogController@getLogActivityData')->name('activity_log.get-data');
    Route::get('/user-login', 'UserActivityLogController@login_index')->name('activity_log.login');
    Route::get('/get-login-logout-data', 'UserActivityLogController@getLoginLogoutData')->name('activity_log.login-data');

    Route::post('/destroy-all', 'UserActivityLogController@log_activity_destroy_all')->name('activity_log.destroy_all')->middleware('prohibited_demo_mode');
    Route::post('/user-login/destroy-all', 'UserActivityLogController@login_activity_destroy_all')->name('activity_log.login.destroy_all')->middleware('prohibited_demo_mode');
});

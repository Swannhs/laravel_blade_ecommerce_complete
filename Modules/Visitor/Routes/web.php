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

Route::prefix('visitor')->group(function() {
    Route::get('/', 'VisitorController@index');
    Route::get('/ignore-ip', 'IgnoreVisitorController@index')->name('ignore_ip_list');
    Route::get('/ignore-ip-list', 'IgnoreVisitorController@getIPList')->name('ignore_ip_list_data');
    Route::post('/ignore-ip/store', 'IgnoreVisitorController@store')->name('ignore_ip_list_store')->middleware('prohibited_demo_mode');
    Route::get('/ignore-ip/delete/{id}', 'IgnoreVisitorController@destroy')->name('ignore_ip_list_destroy')->middleware('prohibited_demo_mode');
});

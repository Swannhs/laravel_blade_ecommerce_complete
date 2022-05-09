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

Route::middleware(['admin'])->prefix('gst-setup/gst')->group(function() {
    Route::get('/', 'GSTController@index')->name('gst_tax.index')->middleware(['permission']);
    Route::get('/list', 'GSTController@list')->name('gst_tax.list');
    Route::post('/store', 'GSTController@store')->name('gst_tax.store')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/update/{id}', 'GSTController@update')->name('gst_tax.update')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/delete/{id}', 'GSTController@destroy')->name('gst_tax.destroy')->middleware(['permission','prohibited_demo_mode']);

    Route::get('/configuration', 'GSTController@configuration')->name('gst_tax.configuration_index')->middleware(['permission']);
    Route::post('/configuration-update', 'GSTController@configuration_update')->name('gst_tax.configuration_update')->middleware(['permission','prohibited_demo_mode']);
});

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

Route::prefix('utilities')->group(function() {
    Route::get('/', 'UtilitiesController@index')->name('utilities.index')->middleware(['permission']);
    Route::post('/reset-database', 'UtilitiesController@reset_database')->name('utilities.reset_database')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/import-demo-database', 'UtilitiesController@import_demo_database')->name('utilities.import_demo_database')->middleware(['prohibited_demo_mode']);
    Route::post('/xml-sitemap', 'UtilitiesController@xml_sitemap')->name('utilities.xml_sitemap')->middleware(['permission']);

});

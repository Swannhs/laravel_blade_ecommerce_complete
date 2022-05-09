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

Route::middleware(['auth','admin','permission'])->prefix('appearance')->as('appearance.')->group(function() {

    //themes
    Route::resource('/themes', 'ThemeController')->except('destroy','update','edit');
    Route::post('/themes/store','ThemeController@store')->name('themes.store')->middleware('prohibited_demo_mode');
    Route::post('/themes/active','ThemeController@active')->name('themes.active')->middleware('prohibited_demo_mode');
    Route::post('/themes/detele','ThemeController@destroy')->name('themes.delete')->middleware('prohibited_demo_mode');

    //header
    Route::get('/headers','HeaderController@index')->name('header.index');
    Route::get('/headers/setup/{id}','HeaderController@setup')->name('header.setup');
    Route::post('/headers/update','HeaderController@update')->name('header.update')->middleware('prohibited_demo_mode');
    Route::post('/headers/update-status','HeaderController@update_status')->name('header.update_status')->middleware('prohibited_demo_mode');
    Route::post('/headers/setup/add-element','HeaderController@addElement')->name('header.setup.add-element')->middleware('prohibited_demo_mode');
    Route::post('/headers/setup/update-element','HeaderController@updateElement')->name('header.setup.update-element')->middleware('prohibited_demo_mode');
    Route::post('/headers/setup/delete-element','HeaderController@deleteElement')->name('header.setup.delete-element')->middleware('prohibited_demo_mode');
    Route::post('/headers/setup/sort-element','HeaderController@sortElement')->name('header.setup.sort-element')->middleware('prohibited_demo_mode');

    Route::post('/headers/setup/get-slider-type-data','HeaderController@getSliderTypeData')->name('header.get-slider-type-data')->middleware('prohibited_demo_mode');


    Route::get('/dashboard', 'DashboardController@index')->name('dashoboard.index');
    Route::post('/setup-update', 'DashboardController@update_status')->name('dashoboard.status_update')->middleware('prohibited_demo_mode');

    //color
    Route::get('/get-data','ColorController@get_data')->name('color.get_data');
    Route::post('/color-activate/{id}','ColorController@activate')->name('color.activate')->middleware('prohibited_demo_mode');
    Route::get('/color-clone/{id}','ColorController@clone')->name('color.clone')->middleware('prohibited_demo_mode');;
    Route::get('/color/delete/{id}','ColorController@destroy')->name('color.delete')->middleware('prohibited_demo_mode');;
    Route::resource('color', ColorController::class);

    //theme color
    Route::get('/theme-color','ThemeColorController@index')->name('themeColor.index');
    Route::post('/theme-color/{id}','ThemeColorController@update')->name('themeColor.update')->middleware('prohibited_demo_mode');
    Route::get('/theme-color-activate/{id}','ThemeColorController@activate')->name('themeColor.activate')->middleware('prohibited_demo_mode');;

});



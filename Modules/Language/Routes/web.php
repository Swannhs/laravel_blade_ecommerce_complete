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

Route::middleware(['admin'])->prefix('setup/language')->group(function() {
    Route::get('/', 'LanguageController@index')->name('languages.index')->middleware(['permission']);
    Route::get('/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/edit', 'LanguageController@edit')->name('languages.edit')->middleware('permission');
    Route::post('/store', 'LanguageController@store')->name('languages.store')->middleware(['permission','prohibited_demo_mode']);
    Route::put('/update/{id}', 'LanguageController@update')->name('languages.update')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/translate-view/{id}', 'LanguageController@show')->name('language.translate_view')->middleware(['permission']);
    Route::post('/update-active-status', 'LanguageController@update_active_status')->name('languages.update_active_status')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/set-language', 'LanguageController@changeLanguage')->name('language.change')->middleware('prohibited_demo_mode');

    Route::post('/update-rtl-status', 'LanguageController@update_rtl_status')->name('languages.update_rtl_status')->middleware(['permission','prohibited_demo_mode']);
	Route::post('/languages/key_value_store', 'LanguageController@key_value_store')->name('languages.key_value_store')->middleware('prohibited_demo_mode');
    Route::post('/get-translate-file', 'LanguageController@get_translate_file')->name('language.get_translate_file');
    Route::get('/search', 'LanguageController@index')->name('languages.search_index');
});

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

Route::prefix('footer')->as('footerSetting.')->group(function() {

    //footer setting
    Route::get('/footer-setting','FooterSettingController@index')->name('footer.index');
    Route::post('/footer-setting','FooterSettingController@contentUpdate')->name('footer.content-update')->middleware('prohibited_demo_mode');
    Route::get('/footer-setting/tab/{id}','FooterSettingController@tabSelect')->name('footer.content-tabselect');

    Route::post('/footer-widget','FooterSettingController@widgetStore')->name('footer.widget-store')->middleware('prohibited_demo_mode');
    Route::post('/footer-widget-status','FooterSettingController@widgetStatus')->name('footer.widget-status')->middleware('prohibited_demo_mode');
    Route::post('/footer-widget-update','FooterSettingController@widgetUpdate')->name('footer.widget-update')->middleware('prohibited_demo_mode');
    Route::get('/footer-widget-delete/{id}','FooterSettingController@destroy')->name('footer.widget-delete')->middleware('prohibited_demo_mode');
});

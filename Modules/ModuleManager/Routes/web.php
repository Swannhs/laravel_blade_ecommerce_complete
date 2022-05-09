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

Route::prefix('modulemanager')->middleware('auth','admin')->group(function () {
    Route::get('/', 'ModuleManagerController@ManageAddOns')->name('modulemanager.index')->middleware(['permission']);
    Route::post('/uploadModule', 'ModuleManagerController@uploadModule')->name('modulemanager.uploadModule')->middleware(['permission','prohibited_demo_mode']);

    Route::get('manage-adons-delete/{name}', 'ModuleManagerController@ManageAddOns')->name('deleteModule')->middleware(['permission','prohibited_demo_mode']);
    Route::get('manage-adons-enable/{name}', 'ModuleManagerController@moduleAddOnsEnable')->name('moduleAddOnsEnable')->middleware(['permission','prohibited_demo_mode']);
    Route::get('manage-adons-disable/{name}', 'ModuleManagerController@moduleAddOnsDisable')->name('moduleAddOnsDisable')->middleware(['permission','prohibited_demo_mode']);
});

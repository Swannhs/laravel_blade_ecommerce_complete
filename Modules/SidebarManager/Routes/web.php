<?php

use Illuminate\Support\Facades\Route;

Route::prefix('sidebar-manager')->middleware(['auth'])->group(function () {
    Route::get('/index', 'SidebarManagerController@index')->name('sidebar-manager.index');
});
Route::post('/store', 'SidebarManagerController@store')->name('sidebar-manager.store')->middleware('prohibited_demo_mode');

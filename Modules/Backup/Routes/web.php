<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin', 'permission'])->group(function () {
    Route::get('/backup', 'BackupController@index')->name('backup.index');
    Route::get('/backup/create', 'BackupController@create')->name('backup.create')->middleware('prohibited_demo_mode');
    Route::get('/backup/delete/{dir}', 'BackupController@delete')->name('backup.delete')->middleware('prohibited_demo_mode');
    Route::post('/import', 'BackupController@import')->name('backup.import')->middleware('prohibited_demo_mode');
});

<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'SpondonIt\Service\Controllers', 'middleware' => 'web'], function () {
    Route::group(['prefix' => 'install'], function(){
        Route::get('pre-requisite', 'InstallController@preRequisite')->name('service.preRequisite');
        Route::get('license', 'InstallController@license')->name('service.license');
        Route::post('license', 'InstallController@post_license');
        Route::get('database', 'InstallController@database')->name('service.database');
        Route::post('database', 'InstallController@post_database');
        Route::get('done', 'InstallController@done')->name('service.done');
        Route::get('uninstall', 'InstallController@uninstall')->name('service.uninstall');
    });

    Route::get('/update', 'UpdateController@index')->name('service.update');
    Route::post('/update', 'UpdateController@update');
    Route::post('/download', 'UpdateController@download')->name('service.delete');
    Route::post('/install-adons', 'InstallController@ManageAddOnsValidation')->name('ManageAddOnsValidation');
    Route::post('/revoke', 'LicenseController@revoke')->name('service.revoke');
    Route::post('/revoke-adons', 'LicenseController@revokeModule')->name('service.revoke.module');

});



<?php

use Illuminate\Support\Facades\Route;

Route::prefix('form-builder/')->as('form_builder.')->middleware(['auth','admin'])->group(function () {
    Route::resource('forms', 'FormBuilderController')->only(['index','show']);
    Route::get('/builder/{id}', 'FormBuilderController@builder')->name('builder');
    Route::post('/builder', 'FormBuilderController@builderUpdate')->name('builder.update')->middleware('prohibited_demo_mode');

});

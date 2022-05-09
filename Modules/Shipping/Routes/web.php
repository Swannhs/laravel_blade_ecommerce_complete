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

Route::middleware(['admin'])->prefix('/setup/shipping-methods')->group(function() {
    Route::get('/', 'ShippingController@index')->name('shipping_methods.index')->middleware(['permission']);
    Route::get('/list', 'ShippingController@create')->name('shipping_methods.create');
    Route::post('/store', 'ShippingController@store')->name('shipping_methods.store')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/edit/{id}', 'ShippingController@edit')->name('shipping_methods.edit');
    Route::post('/update', 'ShippingController@update')->name('shipping_methods.update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/update-status', 'ShippingController@update_status')->name('shipping_methods.update_status')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/update-approve-status', 'ShippingController@update_approve_status')->name('shipping_methods.update_approve_status')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/delete', 'ShippingController@destroy')->name('shipping_methods.destroy')->middleware(['permission','prohibited_demo_mode']);
});

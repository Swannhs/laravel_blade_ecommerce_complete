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

Route::prefix('admin/in-house-order')->as('admin.inhouse-order.')->group(function() {

    // inhouse order
    Route::get('/', 'InhouseOrderController@index')->name('index');
    Route::get('/get-data', 'InhouseOrderController@getData')->name('get-data')->middleware(['permission']);
    Route::get('/create', 'InhouseOrderController@create')->name('create')->middleware(['permission']);
    Route::post('/store', 'InhouseOrderController@store')->name('store');
    Route::get('/get-product-variant', 'InhouseOrderController@getProductVariant');
    Route::post('/add-to-cart', 'InhouseOrderController@addToCart')->name('add-to-cart');
    Route::post('/change-shipping-method', 'InhouseOrderController@changeShippingMethod')->name('change-shipping-method');
    Route::post('/change-qty', 'InhouseOrderController@changeQty')->name('change-qty');
    Route::post('/delete', 'InhouseOrderController@destroy')->name('delete');
    Route::post('/address-save', 'InhouseOrderController@addressSave')->name('save_address');
    Route::get('/reset-address', 'InhouseOrderController@resetAddress')->name('reset-address');
});

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

Route::prefix('customer')->group(function() {
    Route::get('/active-customer-list', 'CustomerController@customer_index')->name('cusotmer.list_active')->middleware(['admin','permission']);
    Route::get('/customer-list/get-data', 'CustomerController@customer_index_get_data')->name('cusotmer.list.get-data')->middleware(['admin']);
    Route::post('/is-active/update','CustomerController@update_active_status')->name('customer.update_active_status')->middleware(['admin','permission','prohibited_demo_mode']);
    Route::get('/profile/details/{id}/get-orders','CustomerController@getOrders')->name('customer.show_details.get-orders')->middleware(['admin']);
    Route::get('/profile/details/{id}/get-wallet-history','CustomerController@getWalletHistory')->name('customer.show_details.get-wallet-history')->middleware(['admin']);
    Route::post('/password/update','CustomerController@updatePassword')->name('cusotmer.update.password')->middleware(['auth','prohibited_demo_mode']);
    Route::post('/info/update','CustomerController@updateInfo')->name('customer.update.info')->middleware(['auth','prohibited_demo_mode']);
    Route::post('/address/store','CustomerController@storeAddress')->name('customer.address.store')->middleware(['auth','prohibited_demo_mode']);
    Route::post('/address/update','CustomerController@updateAddress')->name('customer.address.update')->middleware(['auth','prohibited_demo_mode']);
    Route::post('/address/default/shipping','CustomerController@setDefaultShipping')->name('customer.address.default.shipping')->middleware(['auth','prohibited_demo_mode']);
    Route::post('/address/default/billing','CustomerController@setDefaultBilling')->name('customer.address.default.billing')->middleware(['auth','prohibited_demo_mode']);
    Route::post('/address/delete','CustomerController@deleteAddress')->name('customer.address.delete')->middleware(['auth','prohibited_demo_mode']);
    Route::get('/profile/details/{id}','CustomerController@show')->name('customer.show_details')->middleware(['admin','permission']);

});
Route::get('/customer/address/edit/{c_id}','CustomerController@editAddress')->middleware('auth');

Route::prefix('admin')->middleware(['auth','admin'])->as('admin.')->group(function () {
   Route::get('/customer/create', 'CustomerController@create')->name('customer.create')->middleware('permission'); 
   Route::post('/customer/store', 'CustomerController@store')->name('customer.store')->middleware('prohibited_demo_mode'); 
   Route::get('/customer/{id}/edit', 'CustomerController@edit')->name('customer.edit')->middleware('permission'); 
   Route::post('/customer/update/{id}', 'CustomerController@update')->name('customer.update')->middleware('prohibited_demo_mode'); 
   Route::get('/customer/{id}/destroy', 'CustomerController@destroy')->name('customer.destroy')->middleware('permission'); 
});

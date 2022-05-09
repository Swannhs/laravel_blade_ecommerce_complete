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
use Modules\Setup\Http\Controllers\CountryController;

Route::middleware(['seller'])->prefix('seller')->as('seller.')->group(function() {

    //support ticket
    Route::get('/support-ticket','SupportTicketController@index')->name('support-ticket.index');
    Route::get('/support-ticket/get-data','SupportTicketController@getData')->name('support-ticket.get-data');
    Route::get('/support-ticket/create','SupportTicketController@create')->name('support-ticket.create');
    Route::get('/support-ticket/{id}/edit','SupportTicketController@edit')->name('support-ticket.edit');
    Route::post('/support-ticket','SupportTicketController@store')->name('support-ticket.store')->middleware('prohibited_demo_mode');
    Route::post('/support-ticket/update/{id}','SupportTicketController@update')->name('support-ticket.update')->middleware('prohibited_demo_mode');
    Route::get('/support-ticket/{id}/show','SupportTicketController@show')->name('support-ticket.show');
    Route::post('/support-ticket/message','SupportTicketController@message')->name('ticket.message')->middleware('prohibited_demo_mode');
    Route::get('/support-ticket/search','SupportTicketController@search')->name('ticket.search');

    //product reviews
    Route::get('/product-reviews','ProductReviewsController@index')->name('product-reviews.index');
    Route::get('/product-reviews/get-data','ProductReviewsController@getData')->name('product-reviews.get-data')->middleware(['permission']);
    Route::get('/product-reviews/reply','ProductReviewsController@reply')->name('product-reviews.reply')->middleware(['permission']);
    Route::post('/product-reviews/reply','ProductReviewsController@replyStore')->name('product-reviews.reply.store')->middleware('prohibited_demo_mode');

    //seller reviews
    Route::get('/my-reviews','SellerReviewsController@index')->name('my-reviews.index');
    Route::get('/my-reviews/get-data','SellerReviewsController@getData')->name('my-reviews.get-data');


    //reports
    Route::get('/reports','ReportsController@index')->name('reports.index');

    

    //products
    Route::get('/product','ProductController@index')->name('product.index');
    Route::get('/product/get-data','ProductController@getData')->name('product.get-data');
    Route::post('/product-stock-status','ProductController@update_stock_manage_status')->name('product.update_stock_manage_status')->middleware('prohibited_demo_mode');
    Route::get('/product/{id}','ProductController@getProduct')->name('product.getByID');
    Route::post('/product-store','ProductController@store')->name('product.store')->middleware('prohibited_demo_mode');
    Route::post('/product/show','ProductController@show')->name('product.show');
    Route::post('/admin-product/show','ProductController@admin_product_show')->name('admin_product.show');
    Route::post('/product/delete','ProductController@destroy')->name('product.delete')->middleware('prohibited_demo_mode');
    Route::get('/product/edit/{id}','ProductController@edit')->name('product.edit');
    Route::post('/product/update/{id}','ProductController@update')->name('product.update')->middleware('prohibited_demo_mode');
    Route::post('/product/update-status','ProductController@updateStatus')->name('product.update-status')->middleware('prohibited_demo_mode');
    Route::post('/product/variant','ProductController@variant')->name('product.variant');
    Route::post('/product/variant/edit','ProductController@variantEdit')->name('product.variant-edit');

    Route::post('/product/variant/delete','ProductController@variantDelete')->name('product.variant.delete')->middleware('prohibited_demo_mode');

    //my product
    Route::get('/products/create','ProductController@create')->name('product.create')->middleware(['permission']);
    Route::get('/product/{id}/edit','ProductController@myProductEdit')->name('my-product.edit');
    Route::get('/product/{id}/clone','ProductController@myProductClone')->name('my-product.clone')->middleware('prohibited_demo_mode');


    Route::resource('/supplier', 'SupplierController')->except('destroy');
    Route::post('/supplier/delete','SupplierController@destroy')->name('supplier.delete');
    Route::post('/supplier/status-update','SupplierController@statusChange')->name('supplier.status-update');


});

Route::prefix('seller')->as('seller.')->group(function() {
    Route::get('/profile/get-state',[CountryController::class, 'get_states'])->name('profile.get-state');
    Route::get('/profile/get-city',[CountryController::class, 'get_cities'])->name('profile.get-city');
    Route::post('/get-seller-product-ku-wise-price', 'ProductController@get_seller_product_sku_wise_price')->name('get_seller_product_sku_wise_price');
});



Route::middleware(['admin'])->prefix('admin')->group(function() {
    if(isModuleActive('MultiVendor')){
    //inhouse product
    Route::get('/inhouse/product','ProductController@index')->name('admin.my-product.index')->middleware(['permission']);
    Route::get('/inhouse/products/create','ProductController@create')->name('admin.my-product.create')->middleware(['permission']);
    Route::get('/inhouse/product/edit/{id}','ProductController@edit')->name('admin.my-product.edit')->middleware(['permission']);
    }

});

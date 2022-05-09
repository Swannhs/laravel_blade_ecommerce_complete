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

Route::middleware(['admin'])->prefix('review')->as('review.')->group(function() {

    //product review approve
    Route::get('/product-list','AproveProductReviewController@index')->name('product.index')->middleware(['permission']);
    Route::get('/product-list/get-data','AproveProductReviewController@allGetData')->name('product.get-all-data')->middleware(['permission']);
    Route::get('/product-list/get-pending-data','AproveProductReviewController@pendingGetData')->name('product.get-pending-data')->middleware(['permission']);
    Route::get('/product-list/get-decline-data','AproveProductReviewController@declinedGetData')->name('product.get-declined-data')->middleware(['permission']);

    Route::post('/product/approve','AproveProductReviewController@approve')->name('product.approve')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/product/approve-all','AproveProductReviewController@approveAll')->name('product.approve-all')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/product/delete','AproveProductReviewController@destroy')->name('product.delete')->middleware(['permission','prohibited_demo_mode']);

    //seller review approve
    Route::get('/seller-list','ApproveSellerReviewController@index')->name('seller.index')->middleware(['permission']);
    Route::get('/seller-list/get-all-data','ApproveSellerReviewController@getAllData')->name('seller.get-all-data')->middleware(['permission']);
    Route::get('/seller-list/get-pending-data','ApproveSellerReviewController@getPendingData')->name('seller.get-pending-data')->middleware(['permission']);
    Route::get('/seller-list/get-declined-data','ApproveSellerReviewController@getDeclinedData')->name('seller.get-declined-data')->middleware(['permission']);
    Route::post('/seller/approve','ApproveSellerReviewController@approve')->name('seller.approve')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/seller/approve-all','ApproveSellerReviewController@approveAll')->name('seller.approve-all')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/seller/delete','ApproveSellerReviewController@destroy')->name('seller.delete')->middleware(['permission','prohibited_demo_mode']);

    // configurateion
    Route::get('/review_configuration','AproveProductReviewController@review_configuration')->name('review_configuration')->middleware(['permission']);
    Route::post('/review_configuration','AproveProductReviewController@review_configuration_update')->name('review_configuration.update')->middleware(['permission','prohibited_demo_mode']);

});

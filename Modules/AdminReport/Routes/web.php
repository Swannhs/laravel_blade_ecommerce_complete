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

Route::prefix('admin-report')->group(function() {

    Route::get('/user-searches-keyword', 'SearchKeywordController@index')->name('report.user_searches');
    Route::get('/get-search-keyword-data', 'SearchKeywordController@get_search_keyword_data')->name('report.get_search_keyword_data');
    Route::get('/user-searches-keyword/destroy/{id}', 'SearchKeywordController@destroy')->name('report.user_search_destroy');

    Route::get('/visitor-report', 'AdminReportController@visitor_index')->name('report.visitor_report');
    Route::get('/get-visitor-data', 'AdminReportController@get_visitor_data')->name('report.get_visitor_data');
    if(isModuleActive('MultiVendor')){
    Route::get('/seller-wise-sale-report', 'SaleReportController@seller_wise_index')->name('report.seller_wise_sales');
    }
    Route::get('/get-seller-wise-sale-report-data/{seller_id}/{sale_type}', 'SaleReportController@get_seller_wise_sale_report_data')->name('report.get_seller_wise_sale_report_data');

    Route::get('/inhouse-product-sale', 'AdminReportController@inhouse_product_sale')->name('report.inhouse_product_sale');

    Route::get('/product-stock', 'AdminReportController@product_stock')->name('report.product_stock');
    Route::get('/product-stock-data', 'AdminReportController@product_stock_data')->name('report.product_stock_data');

    Route::get('/wishlist', 'AdminReportController@wishlist')->name('report.wishlist');
    Route::get('/wishlist-data', 'AdminReportController@wishlist_data')->name('report.wishlist_data');

    Route::get('/wallet-recharge-history', 'AdminReportController@wallet_recharge_history')->name('report.wallet_recharge_history');
    Route::get('/wallet-recharge-history-data', 'AdminReportController@wallet_recharge_history_data')->name('report.wallet_recharge_history_data');

    Route::get('/order', 'AdminReportController@order')->name('report.order');
    Route::get('/order-data', 'AdminReportController@order_data')->name('report.order_data');

    Route::get('/payment', 'AdminReportController@payment')->name('report.payment');
    Route::get('/payment-data', 'AdminReportController@payment_data')->name('report.payment_data');
    if(isModuleActive('MultiVendor')){
    Route::get('/top-seller', 'AdminReportController@top_seller')->name('report.top_seller');
    Route::get('/top-seller-data', 'AdminReportController@top_seller_data')->name('report.top_seller_data');
    }
    
    Route::get('/top-customer', 'AdminReportController@top_customer')->name('report.top_customer');
    Route::get('/top-customer-data', 'AdminReportController@top_customer_data')->name('report.top_customer_data');

    Route::get('/top-selling-item', 'AdminReportController@top_selling_item')->name('report.top_selling_item');
    Route::get('/top-selling-item-data', 'AdminReportController@top_selling_item_data')->name('report.top_selling_item_data');

    Route::get('/product-review', 'AdminReportController@product_review')->name('report.product_review');
    Route::get('/product-review-data', 'AdminReportController@product_review_data')->name('report.product_review_data');

    Route::get('/seller-review', 'AdminReportController@seller_review')->name('report.seller_review');
    Route::get('/seller-review-data', 'AdminReportController@seller_review_data')->name('report.seller_review_data');

});

Route::prefix('seller-report')->group(function() {

    Route::get('/product', 'SellerReportController@product')->name('seller_report.product');

    Route::get('/order', 'SellerReportController@order')->name('seller_report.order');
    Route::get('/order-data', 'SellerReportController@order_data')->name('seller_report.order_data');

    Route::get('/top-customer', 'SellerReportController@top_customer')->name('seller_report.top_customer');
    Route::get('/top-customer-data', 'SellerReportController@top_customer_data')->name('seller_report.top_customer_data');

    Route::get('/top-selling-item', 'SellerReportController@top_selling_item')->name('seller_report.top_selling_item');
    Route::get('/top-selling-item-data', 'SellerReportController@top_selling_item_data')->name('seller_report.top_selling_item_data');

    Route::get('/review', 'SellerReportController@review')->name('seller_report.review');
    Route::get('/review-data', 'SellerReportController@review_data')->name('seller_report.review_data');

});

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

Route::prefix('refund')->group(function() {
    Route::get('/', 'RefundController@index');

    Route::middleware(['admin'])->group(function(){
        Route::get('/reasons', 'RefundReasonController@index')->name('refund.index')->middleware(['permission']);
        Route::get('/reasons-list', 'RefundReasonController@reasons_list')->name('refund.reasons_list');
        Route::post('/reasons-store', 'RefundReasonController@store')->name('refund.reasons_store')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/refund-reason-update/{id}', 'RefundReasonController@update')->name('refund.reasons_update')->middleware(['permission','prohibited_demo_mode']);
        Route::get('/reason-destroy/{id}', 'RefundReasonController@destroy')->name('refund.destroy')->middleware(['permission','prohibited_demo_mode']);

        Route::get('/refund-peocess', 'RefundProcessController@index')->name('refund.process_index')->middleware(['permission']);
        Route::get('/refund-peocess-list', 'RefundProcessController@process_list')->name('refund.process_list');
        Route::post('/refund-peocess-store', 'RefundProcessController@store')->name('refund.process_store')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/refund-peocess-update/{id}', 'RefundProcessController@update')->name('refund.process_update')->middleware(['permission','prohibited_demo_mode']);
        Route::get('/refund-peocess-destroy/{id}', 'RefundProcessController@destroy')->name('refund.process_destroy')->middleware(['permission','prohibited_demo_mode']);

        Route::get('/all-pending-refund-request', 'RefundController@all_refund_request_index')->name('refund.total_refund_list')->middleware(['permission']);
        Route::get('/all-pending-refund-request-data', 'RefundController@all_refund_request_data')->name('refund.all_refund_request_data')->middleware(['permission']);

        Route::get('/all-confirmed-refund-request', 'RefundController@all_refund_request_confirmed_index')->name('refund.confirmed_refund_requests');

        Route::get('/refund-request-details/{id}', 'RefundController@show')->name('refund.refund_show_details')->middleware(['permission']);
        Route::post('/update-refund-request-info/{id}', 'RefundController@update_refund_request_by_admin')->name('refund.update_refund_request_by_admin')->middleware(['permission','prohibited_demo_mode']);

        Route::get('/configuration', 'RefundController@config_index')->name('refund.config')->middleware(['permission']);
        Route::post('/refund-config-update', 'RefundController@config_update')->name('refund.refund_config_store')->middleware(['permission','prohibited_demo_mode']);
    });

    Route::middleware(['seller'])->group(function(){
        Route::get('/my-refund-request', 'RefundController@seller_refund_request_list')->name('refund.my_refund_list');
        Route::post('/update-refund-state-info/{id}', 'RefundController@update_refund_state_by_seller')->name('refund.update_refund_detail_state_by_seller')->middleware(['permission','prohibited_demo_mode']);
        Route::get('/seller-refund-request-details/{id}', 'RefundController@seller_show')->name('refund.seller_refund_show_details');
        Route::get('/seller-pending-refund-request-data', 'RefundController@seller_refund_request_data')->name('refund.seller_refund_request_data');
    });
    Route::post('/get-refund-package-data', 'RefundController@getRefundPackage')->name('refund.get_refund_package_data');
    
    Route::middleware(['auth','customer'])->group(function(){
        Route::get('/make-refund-request/{id}', 'RefundController@make_refund_request')->name('refund.make_request');
        Route::post('/make-refund-request-store', 'RefundController@store')->name('refund.refund_make_request_store')->middleware('prohibited_demo_mode');
        Route::get('/my-refund-list', 'RefundController@my_refund_index')->name('refund.frontend.index');
        Route::get('/my-refund-details/{id}', 'RefundController@my_refund_show')->name('refund.frontend.my_refund_order_detail');
    });

});

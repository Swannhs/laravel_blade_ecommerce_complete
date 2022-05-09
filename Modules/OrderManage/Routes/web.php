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

Route::prefix('ordermanage')->group(function () {
    Route::get('/', 'OrderManageController@index')->middleware(['seller']);
    Route::get('/my-sales-list', 'OrderManageController@my_sales_index')->name('order_manage.my_sales_index')->middleware(['seller']);
    Route::get('/my-sales-list/get-data', 'OrderManageController@my_sales_get_data')->name('order_manage.my_sales_get_data')->middleware(['seller']);
    Route::get('/my-sales-details/{id}', 'OrderManageController@my_sale_show')->name('order_manage.show_details_mine')->middleware(['seller']);
    Route::get('/my-sales-details-refund/{id}', 'OrderManageController@my_sale_show_for_refund')->name('order_manage.my_sale_show_for_refund')->middleware(['seller']);
    Route::get('/sales-details-print/{id}', 'OrderManageController@globalPrint')->name('order_manage.print_order_details')->middleware(['seller']);
    Route::get('/my-sales-details-print/{id}', 'OrderManageController@personalPrint')->name('my_order_manage.print_order_details')->middleware(['seller']);
    Route::post('/sales-info-update-delivery/{id}', 'OrderManageController@update_delivery')->name('order_manage.update_delivery_status')->middleware(['seller']);
    Route::post('/delivery-status-update-customer', 'OrderManageController@change_delivery_status_by_customer')->name('change_delivery_status_by_customer')->middleware(['auth']);


    Route::middleware(['admin'])->group(function () {
        Route::post('/sales-info-update-admin/{id}', 'OrderManageController@sales_info_update')->name('order_manage.order_update_info')->middleware(['permission']);
        Route::get('/total-sales-list', 'OrderManageController@total_sales_index')->name('order_manage.total_sales_index');
        Route::get('/total-sales-list/get-data', 'OrderManageController@total_sales_get_data')->name('order_manage.total_sales_get_data')->middleware(['permission']);
        Route::get('/sales-details/{id}', 'OrderManageController@show')->name('order_manage.show_details')->middleware(['permission']);
        Route::get('/order/confirm/{id}', 'OrderManageController@orderConfirm')->name('admin.order.confirm');
        Route::get('/delivery-process', 'DeliveryProcessController@index')->name('order_manage.process_index');
        Route::get('/delivery-process-list', 'DeliveryProcessController@process_list')->name('order_manage.process_list');
        Route::post('/delivery-process-store', 'DeliveryProcessController@store')->name('order_manage.process_store')->middleware('prohibited_demo_mode');
        Route::post('/delivery-processs/update', 'DeliveryProcessController@update')->name('admin.delivery-process.update')->middleware('prohibited_demo_mode');
        Route::get('/delivery-process-destroy/{id}', 'DeliveryProcessController@destroy')->name('order_manage.process_destroy')->middleware('prohibited_demo_mode');
        Route::get('/cancel-reason', 'CancelReasonController@index')->name('order_manage.cancel_reason_index');
        Route::get('/cancel-reason-list', 'CancelReasonController@process_list')->name('order_manage.cancel_reason_list');
        Route::post('/cancel-reason-store', 'CancelReasonController@store')->name('order_manage.cancel_reason_store')->middleware('prohibited_demo_mode');
        Route::post('/cancel-reason-update/{id}', 'CancelReasonController@update')->name('order_manage.cancel_reason_update')->middleware('prohibited_demo_mode');
        Route::get('/cancel-reason-destroy/{id}', 'CancelReasonController@destroy')->name('order_manage.cancel_reason_destroy')->middleware('prohibited_demo_mode');

        Route::post('send-gift-card-code-to-mail', 'OrderManageController@send_gift_card_code')->name('send_gift_card_code_to_customer');
        Route::post('send-digital-file-access-to-mail', 'OrderManageController@send_digital_file_access')->name('send_digital_file_access_to_customer');

        // configurateion
        Route::get('/track_order_configuration', 'OrderManageController@track_order_configuration')->name('track_order_configuration');
        Route::post('/track_order_configuration', 'OrderManageController@track_order_configuration_update')->name('track_order_configuration.update')->middleware('prohibited_demo_mode');

        Route::post('/get-package-by-id', 'OrderManageController@getPackageInfo')->name('order_manage.get_package_info');
    });
});

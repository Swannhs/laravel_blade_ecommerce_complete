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

Route::prefix('wallet')->group(function() {
    Route::middleware(['admin'])->group(function() {
        Route::get('/online-recharge-requests', 'WalletController@index')->name('wallet_recharge.index');
        Route::get('/online-recharge-requests/get-data', 'WalletController@rechargeRequestGetData')->name('wallet_recharge.get-data')->middleware(['permission']);
        Route::get('/bank-recharge-requests', 'WalletController@BankRechargeIndex')->name('bank_recharge.index');
        Route::get('/bank-recharge-requests/get-data', 'WalletController@bankRechargeRequestGetData')->name('bank_recharge.get-data')->middleware(['permission']);
        Route::get('/recharge-offline-index', 'WalletController@offline_index')->name('wallet_recharge.offline_index');
        Route::get('/recharge-offline-index/get-data', 'WalletController@offline_index_get_data')->name('wallet_recharge.offline_index_get_data')->middleware(['permission']);
        Route::post('/offline-recharge-wallet-store', 'WalletController@offline_recharge_store')->name('wallet_recharge.offline')->middleware('prohibited_demo_mode');
        Route::post('/offline-recharge-wallet-update', 'WalletController@offline_recharge_update')->name('wallet_recharge.offline_update')->middleware('prohibited_demo_mode');
        Route::get('/offline-recharge-wallet/get-user-by-role', 'WalletController@getUserByRole')->name('wallet_recharge.get-user-by-role');
        Route::post('/my-wallet-recharge-status', 'WalletController@recharge_status')->name('wallet_charge.update_status')->middleware('prohibited_demo_mode');
        if(isModuleActive('MultiVendor')){
            Route::get('/withdraw-requests', 'WithdrawRequestController@withdraw_requests')->name('wallet.withdraw_requests');
            Route::get('/withdraw-requests/get-data', 'WithdrawRequestController@withdraw_requests_get_data')->name('wallet.withdraw_requests.get_data')->middleware(['permission']);
            Route::get('/withdraw-requests/show/{id}', 'WithdrawRequestController@withdraw_requests_show')->name('wallet.withdraw_requests.show');
            Route::post('/withdraw-requests-status-update/{id}', 'WithdrawRequestController@withdraw_request_status_update')->name('wallet.withdraw_request_status_update')->middleware('prohibited_demo_mode');
        }
        // Configuration
        Route::get('/wallet-configuration', 'WalletController@wallet_configuration')->name('wallet.wallet_configuration');
        Route::post('/wallet-configuration', 'WalletController@wallet_configuration_update')->name('wallet.wallet_configuration_update')->middleware('prohibited_demo_mode');

    });

    
    Route::group(['prefix' => '{subject?}', 'where' => ['subject' => 'customer|seller|admin']],function (){
        Route::get('my-wallet-index', 'WalletController@my_index')->name('my-wallet.index')->middleware(['auth','customer']);
        Route::get('my-wallet-index/get-data', 'WalletController@my_index_get_data')->name('my-wallet.get-data')->middleware(['auth','customer']);
    });
    

    Route::middleware(['auth'])->group(function() {
        Route::post('/my-wallet-store', 'WalletController@store')->name('my-wallet.store')->middleware('prohibited_demo_mode');
        Route::post('/my-wallet-create', 'WalletController@create')->name('my-wallet.recharge_create')->middleware('prohibited_demo_mode');
        Route::get('/my-withdraw-requests', 'WithdrawRequestController@index')->name('my-wallet.withdraw_index');
        Route::get('/my-withdraw-requests/get-data', 'WithdrawRequestController@my_withdraw_request_get_data')->name('my-wallet.withdraw_get_data');
        Route::post('/my-wallet-withdraw-request-sent', 'WithdrawRequestController@withdraw_request_store')->name('my-wallet.withdraw_request_sent')->middleware('prohibited_demo_mode');
        Route::post('/withdraw-requests/update', 'WithdrawRequestController@withdraw_request_update')->name('my-wallet.withdraw_request_update')->middleware('prohibited_demo_mode');
    });
});

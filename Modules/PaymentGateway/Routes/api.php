<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('payment-gateway')->group(function () {
    Route::get('/','API\PaymentMethodController@index');
    Route::get('/{id}','API\PaymentMethodController@show');
    Route::get('/bank/bank-info','API\PaymentMethodController@getBankInfo');
    Route::post('/bank/payment-data-store','API\PaymentMethodController@bankPaymentDataStore')->middleware('auth:sanctum');
});
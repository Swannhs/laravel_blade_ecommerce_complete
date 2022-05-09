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

Route::prefix('order-manage')->group(function(){
    //reason 
    Route::get('/cancel-reason-list','API\OrderCancelReasonController@index');
    Route::get('/cancel-reason/{id}','API\OrderCancelReasonController@reason');

    //cancel api
    Route::post('/cancel-store','API\OrderCancelReasonController@cancelStore')->middleware('auth:sanctum');
});

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

Route::prefix('refund')->group(function(){
    //reason 
    Route::get('/reason-list','API\RefundController@reasonList');
    Route::get('/reason/{id}','API\RefundController@reason');

    // process
    Route::get('/process-list','API\RefundController@processList');
    Route::get('/process/{id}','API\RefundController@process');

});
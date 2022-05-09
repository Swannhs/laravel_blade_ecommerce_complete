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

Route::prefix('gift-card')->group(function(){
    Route::get('/list','API\GiftcardController@index');
    Route::get('/{slug}','API\GiftcardController@giftcard');
    Route::get('/my-purchased/list','API\GiftcardController@myPurchasedGiftcardList')->middleware('auth:sanctum');
    Route::post('/redeem-to-wallet','API\GiftcardController@giftcardAddToWallet')->middleware('auth:sanctum');
});


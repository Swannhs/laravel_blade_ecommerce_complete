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

Route::prefix('marketing')->group(function () {

    //new user zone
    Route::get('/new-user-zone', 'API\NewUserZoneController@getActiveNewUserZone');
    Route::get('/new-user-zone/{slug}/fetch-product-data','API\NewUserZoneController@fetchProductData');
    Route::get('/new-user-zone/{slug}/fetch-category-data','API\NewUserZoneController@fetchCategoryData');
    Route::get('/new-user-zone/{slug}/fetch-coupon-category-data','API\NewUserZoneController@fetchCouponCategoryData');
    Route::get('/new-user-zone/{slug}/fetch-all-category-data','API\NewUserZoneController@fetchAllCategoryData');
    Route::get('/new-user-zone/{slug}/fetch-all-coupon-category-data','API\NewUserZoneController@fetchAllCouponCategoryData');


    //flash deals
    Route::get('/flash-deal', 'API\FlashDealController@getActiveFlashDeal');

});
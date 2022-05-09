<?php

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

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-notifications', 'Api\NotificationController@userNotifications');
    Route::post('/user-notifications/read-all', 'Api\NotificationController@ReadALLNotifications');
    Route::get('/user-notifications-setting', 'Api\NotificationController@notificationSetting');
    Route::post('/user-notifications-setting/update', 'Api\NotificationController@notificationSettingUpdate');
});

Route::get('/currency-list', 'Api\CurrencyController@index');
Route::get('/general-settings', 'Api\GeneralSettingController@index');
Route::get('/languages', 'Api\GeneralSettingController@getActiveLanguages');

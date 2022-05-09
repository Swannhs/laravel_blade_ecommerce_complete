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

Route::prefix('marketing')->as('marketing.')->group(function() {

    //flash deals
    Route::middleware(['auth','seller'])->group(function() {
        Route::get('/flash-deals', 'FlashDealsController@index')->name('flash-deals')->middleware(['permission']);
        Route::get('/flash-deals/create', 'FlashDealsController@create')->name('flash-deals.create')->middleware(['permission']);
        Route::get('/flash-deals/edit/{id}', 'FlashDealsController@edit')->name('flash-deals.edit')->middleware(['permission']);
        Route::post('/flash-deals/store', 'FlashDealsController@store')->name('flash-deals.store')->middleware('prohibited_demo_mode');
        Route::post('/flash-deals/update/{id}', 'FlashDealsController@update')->name('flash-deals.update')->middleware('prohibited_demo_mode');
        Route::post('/flash-deals/product-list', 'FlashDealsController@productList')->name('flash-deals.product-list');
        Route::post('/flash-deals/product-list-edit', 'FlashDealsController@productListEdit')->name('flash-deals.product-list-edit')->middleware('prohibited_demo_mode');
        Route::post('/flash-deals/status', 'FlashDealsController@statusChange')->name('flash-deals.status')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/flash-deals/featured', 'FlashDealsController@featuredChange')->name('flash-deals.featured')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/flash-deals/delete', 'FlashDealsController@destroy')->name('flash-deals.delete')->middleware(['permission','prohibited_demo_mode']);
    });

    //new user zone
    Route::middleware(['auth','admin','permission'])->group(function() {
        Route::get('/new-user-zone', 'NewUserZoneController@index')->name('new-user-zone')->middleware(['permission']);
        Route::get('/new-user-zone/create', 'NewUserZoneController@create')->name('new-user-zone.create')->middleware(['permission']);
        Route::get('/new-user-zone/edit/{id}', 'NewUserZoneController@edit')->name('new-user-zone.edit')->middleware(['permission']);
        Route::post('/new-user-zone/store', 'NewUserZoneController@store')->name('new-user-zone.store')->middleware('prohibited_demo_mode');
        Route::post('/new-user-zone/update/{id}', 'NewUserZoneController@update')->name('new-user-zone.update')->middleware('prohibited_demo_mode');
        Route::post('/new-user-zone/product-list', 'NewUserZoneController@productList')->name('new-user-zone.product-list');
        Route::post('/new-user-zone/category-list', 'NewUserZoneController@categoryList')->name('new-user-zone.category-list');
        Route::post('/new-user-zone/coupon-category-list', 'NewUserZoneController@couponCategoryList')->name('new-user-zone.coupon-category-list');
        Route::post('/new-user-zone/status', 'NewUserZoneController@statusChange')->name('new-user-zone.status')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/new-user-zone/featured', 'NewUserZoneController@featuredChange')->name('new-user-zone.featured')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/new-user-zone/delete', 'NewUserZoneController@destroy')->name('new-user-zone.delete')->middleware(['permission','prohibited_demo_mode']);
    });

    //subscribers
    Route::middleware(['auth','admin'])->group(function() {
        Route::get('/subscribers', 'SubscriberController@index')->name('subscriber');
        Route::get('/subscribers/get-data', 'SubscriberController@getData')->name('subscriber.get-data')->middleware(['permission']);
        Route::post('/subscriber/delete', 'SubscriberController@destroy')->name('subscriber.delete')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/subscriber/status', 'SubscriberController@statusChange')->name('subscriber.status')->middleware(['permission','prohibited_demo_mode']);
    });


    //Newsletter
    Route::middleware(['auth','admin'])->group(function() {
        Route::get('/news-letter', 'NewsLetterController@index')->name('news-letter');
        Route::get('/news-letter/get-data', 'NewsLetterController@getData')->name('news-letter.get-data')->middleware(['permission']);
        Route::get('/news-letter/role-user', 'NewsLetterController@roleUser')->name('news-letter.role-user');
        Route::post('/news-letter/store', 'NewsLetterController@store')->name('news-letter.store')->middleware('prohibited_demo_mode');
        Route::post('/news-letter/update', 'NewsLetterController@update')->name('news-letter.update')->middleware('prohibited_demo_mode');
        Route::get('/news-letter/create', 'NewsLetterController@create')->name('news-letter.create')->middleware(['permission']);
        Route::get('/news-letter/edit/{id}', 'NewsLetterController@edit')->name('news-letter.edit')->middleware(['permission']);
        Route::post('/news-letter/delete', 'NewsLetterController@destroy')->name('news-letter.delete')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/news-letter/test-mail', 'NewsLetterController@testMail')->name('news-letter.test-mail');
    });
    Route::get('/news-letter/cron-job', 'NewsLetterController@cronjob')->name('news-letter.cronjob');


    //bulk sms
    Route::middleware(['auth','admin'])->group(function() {
        Route::get('/bulk-sms', 'BulkSMSController@index')->name('bulk-sms');
        Route::get('/bulk-sms/get-data', 'BulkSMSController@getData')->name('bulk-sms.get-data')->middleware(['permission']);
        Route::get('/bulk-sms/role-user', 'BulkSMSController@roleUser')->name('bulk-sms.role-user');
        Route::get('/bulk-sms/edit', 'BulkSMSController@edit')->name('bulk-sms.edit')->middleware(['permission']);
        Route::post('/bulk-sms/store', 'BulkSMSController@store')->name('bulk-sms.store')->middleware('prohibited_demo_mode');
        Route::post('/bulk-sms/update', 'BulkSMSController@update')->name('bulk-sms.update')->middleware('prohibited_demo_mode');
        Route::post('/bulk-sms/delete', 'BulkSMSController@destroy')->name('bulk-sms.delete')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/bulk-sms/test-sms', 'BulkSMSController@testSMS')->name('bulk-sms.test-sms')->middleware('prohibited_demo_mode');
    });
    Route::get('/bulk-sms/cron-job', 'BulkSMSController@cronjob')->name('bulk-sms.cronjob');

    // coupon
    Route::middleware(['auth','seller'])->group(function() {
        Route::get('/coupon', 'CouponController@index')->name('coupon');
        Route::get('/coupon/get-data', 'CouponController@getData')->name('coupon.get-data')->middleware(['permission']);
        Route::get('/coupon/get-form', 'CouponController@getForm')->name('coupon.get-form');
        Route::get('/coupon/edit', 'CouponController@edit')->name('coupon.edit');
        Route::post('/coupon/store', 'CouponController@store')->name('coupon.store')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/coupon/update', 'CouponController@update')->name('coupon.update')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/coupon/delete', 'CouponController@destroy')->name('coupon.delete')->middleware(['permission','prohibited_demo_mode']);
        Route::get('/coupon/info', 'CouponController@coupon_info')->name('coupon.coupon_info')->middleware(['permission']);
    });


    //referral code setup
    Route::middleware(['auth','admin'])->group(function() {
        Route::get('/referral-code', 'ReferralCodeController@index')->name('referral-code');
        Route::get('/referral-code/get-data', 'ReferralCodeController@getData')->name('referral-code.get-data')->middleware(['permission']);
        Route::post('/referral-code/update-setup', 'ReferralCodeController@updateSetup')->name('referral-code.update-setup')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/referral-code/status', 'ReferralCodeController@statusChange')->name('referral-code.status')->middleware(['permission','prohibited_demo_mode']);
    });

    Route::get('/configuration', 'NewsLetterController@configuration')->name('configuration')->middleware(['auth','admin']);
});

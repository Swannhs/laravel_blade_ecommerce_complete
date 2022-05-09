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
use App\Http\Middleware\AdminMiddleware;
    Route::middleware([AdminMiddleware::class])->prefix('frontendcms')->as('frontendcms.')->group(function() {
        Route::get('/', 'FrontendCMSController@index');


        //feature
        Route::resource('features', 'FeatureController');
        Route::post('/features/store','FeatureController@store')->name('features.store')->middleware('prohibited_demo_mode');
        Route::get('/features/edit/{id}','FeatureController@edit')->name('features.edit');
        Route::post('/features/update/','FeatureController@update')->name('features.update')->middleware('prohibited_demo_mode');
        Route::post('/features/delete','FeatureController@delete')->name('features.delete')->middleware('prohibited_demo_mode');

        //subscribe content
        Route::get('/subscribe-content', 'SubcribeContentController@index')->name('subscribe-content.index');
        Route::post('/subscribe-content/update', 'SubcribeContentController@update')->name('subscribe-content.update')->middleware('prohibited_demo_mode');
        //popup content
        Route::get('/popup-content', 'SubcribeContentController@popup_index')->name('popup-content.index');
        Route::post('/popup-content/update', 'SubcribeContentController@popup_update')->name('popup-content.update')->middleware('prohibited_demo_mode');

        //about us
        Route::get('/about-us', 'AboutUsController@index')->name('about-us.index');
        Route::post('/about-us/update/{id}', 'AboutUsController@update')->name('about-us.update')->middleware('prohibited_demo_mode');

        //return & exchange
        Route::get('/return-exchange', 'ReturnExchangeController@index')->name('return-exchange.index');
        Route::post('/return-exchange/update', 'ReturnExchangeController@update')->name('return-exchange.update')->middleware('prohibited_demo_mode');

        //contact content
        Route::get('/contact-content', 'ContactContentController@index')->name('contact-content.index');
        Route::post('/contact-content/update', 'ContactContentController@update')->name('contact-content.update')->middleware('prohibited_demo_mode');
        //inquery
        Route::get('/query/create', 'ContactContentController@queryCreate')->name('query.create');
        Route::post('/query/store', 'ContactContentController@queryStore')->name('query.store')->middleware('prohibited_demo_mode');
        Route::post('/query/update','ContactContentController@queryUpdate')->name('query.update')->middleware('prohibited_demo_mode');
        Route::post('/query/delete','ContactContentController@destroy')->name('query.delete')->middleware('prohibited_demo_mode');
        Route::post('/query/status-update','ContactContentController@status')->name('query.status')->middleware('prohibited_demo_mode');
        Route::get('/query/{id}/edit','ContactContentController@queryEdit')->name('query.edit');

        if(isModuleActive('MultiVendor')){
            //merchant
            Route::get('/merchant-content','MerchantContentController@index')->name('merchant-content.index');
            Route::post('/merchant-content/update','MerchantContentController@update')->name('merchant-content.update')->middleware('prohibited_demo_mode');
        }


        //benifits
        Route::post('/benefit','BenifitController@store')->name('benefit.store')->middleware('prohibited_demo_mode');
        Route::post('/benefit/update','BenifitController@update')->name('benefit.update')->middleware('prohibited_demo_mode');
        Route::post('/benefit/delete','BenifitController@destroy')->name('benefit.delete')->middleware('prohibited_demo_mode');

        //working process
        Route::post('/how-it-work','WorkingProcessController@store')->name('how-it-work.store')->middleware('prohibited_demo_mode');
        Route::post('/how-it-work/update','WorkingProcessController@update')->name('working-process.update')->middleware('prohibited_demo_mode');
        Route::post('/how-it-work/delete','WorkingProcessController@destroy')->name('working-process.delete')->middleware('prohibited_demo_mode');

        //faq
        Route::post('/faq','FaqController@store')->name('faq.store')->middleware('prohibited_demo_mode');
        Route::post('/faq/update','FaqController@update')->name('faq.update')->middleware('prohibited_demo_mode');
        Route::post('/faq/delete','FaqController@destroy')->name('faq.delete')->middleware('prohibited_demo_mode');



        //dynamic page creator
        Route::resource('/dynamic-page', 'DynamicPageController')->except(['destroy','update']);
        Route::patch('/dynamic-page/{id}','DynamicPageController@update')->name('dynamic-page.update')->middleware('prohibited_demo_mode');
        Route::post('/dynamic-page/store','DynamicPageController@store')->name('dynamic-page.store')->middleware('prohibited_demo_mode');
        Route::post('/dynamic-page/delete','DynamicPageController@destroy')->name('dynamic-page.delete')->middleware('prohibited_demo_mode');
        Route::post('/dynamic-page/status-update','DynamicPageController@status')->name('dynamic-page.status')->middleware('prohibited_demo_mode');

        //homepage manage
        Route::get('/homepage','WidgetController@index')->name('widget.index');
        Route::post('/homepage/getsection-form','WidgetController@getsectionForm')->name('homepage.getsection-form');
        Route::post('/homepage/update','WidgetController@update')->name('homepage.update')->middleware('prohibited_demo_mode');

        Route::get('/title-setting','FrontendCMSController@title_index')->name('title_index');
        Route::post('/title-setting-update','FrontendCMSController@title_update')->name('title_settings.update')->middleware('prohibited_demo_mode');


    });

    Route::middleware(['admin','auth'])->prefix('admin')->as('admin.')->group(function(){
        //pricing
        Route::resource('/pricing', 'PricingController')->except('destroy, update');
        Route::post('/pricing/delete','PricingController@destroy')->name('pricing.delete')->middleware('prohibited_demo_mode');
        Route::post('/pricing/update','PricingController@update')->name('pricing.update')->middleware('prohibited_demo_mode');
        Route::post('/pricing/status-update','PricingController@status')->name('pricing.status')->middleware('prohibited_demo_mode');
        Route::get('/pricings/list-for-seller','PricingController@get_pricing')->name('pricing.get_pricing_url');
    });
// });

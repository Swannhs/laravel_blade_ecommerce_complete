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

Route::middleware(['admin'])->prefix('setup')->group(function() {

    Route::get('/introPrefix', 'IntroPrefixController@index')->name('introPrefix.index');
    Route::post('/introPrefix/store', 'IntroPrefixController@store')->name('introPrefix.store')->middleware('prohibited_demo_mode');
    Route::post('/introPrefix/edit', 'IntroPrefixController@edit')->name('introPrefix.edit')->middleware('prohibited_demo_mode');
    Route::put('/introPrefix/update/{id}', 'IntroPrefixController@update')->name('introPrefix.update')->middleware('prohibited_demo_mode');
    Route::get('/introPrefix/destroy/{id}', 'IntroPrefixController@destroy')->name('introPrefix.destroy');
    Route::get('/introPrefix/search', 'IntroPrefixController@index')->name('introPrefix.search_index');


    Route::get('/tags', 'TagController@index')->name('tags.index');
    Route::get('/get-tag-list', 'TagController@get_list')->name('tags.get_list');
    Route::get('/get_data', 'TagController@get_data')->name('tags.get_data');
    Route::post('/tag-store', 'TagController@store')->name('tags.store')->middleware('prohibited_demo_mode');
    Route::post('/tag-update/{id}', 'TagController@update')->name('tags.update')->middleware('prohibited_demo_mode');
    Route::get('/tag/destroy/{id}', 'TagController@destroy')->name('tags.destroy')->middleware('prohibited_demo_mode');
    Route::get('/getTagBySentence', 'TagController@getTagBySentence')->name('tags.getTagBySentence');


    // location
    Route::get('/location/country', 'CountryController@index')->name('setup.country.index')->middleware(['permission', 'auth']);
    Route::post('/location/country/store', 'CountryController@store')->name('setup.country.store')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::get('/location/country/edit/{id}', 'CountryController@edit')->name('setup.country.edit');
    Route::post('/location/country/update', 'CountryController@update')->name('setup.country.update')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::post('/location/country/status', 'CountryController@status')->name('setup.country.status')->middleware(['permission', 'auth','prohibited_demo_mode']);

    Route::get('/location/state', 'StateController@index')->name('setup.state.index')->middleware(['permission', 'auth']);
    Route::get('/location/state/get-data', 'StateController@getData')->name('setup.state.getData');
    Route::post('/location/state/store', 'StateController@store')->name('setup.state.store')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::get('/location/state/edit/{id}', 'StateController@edit')->name('setup.state.edit');
    Route::post('/location/state/update', 'StateController@update')->name('setup.state.update')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::post('/location/state/status', 'StateController@status')->name('setup.state.status')->middleware(['permission', 'auth','prohibited_demo_mode']);

    Route::get('/location/city', 'CityController@index')->name('setup.city.index')->middleware(['permission', 'auth']);
    Route::get('/location/city/get-data', 'CityController@getData')->name('setup.city.getData');
    Route::post('/location/city/store', 'CityController@store')->name('setup.city.store')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::get('/location/city/edit/{id}', 'CityController@edit')->name('setup.city.edit');
    Route::post('/location/city/update', 'CityController@update')->name('setup.city.update')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::post('/location/city/status', 'CityController@status')->name('setup.city.status')->middleware(['permission', 'auth','prohibited_demo_mode']);
    Route::post('/location/city/get-state', 'CityController@getState')->name('setup.city.get-state');

});

Route::get('/setup/getTagBySentence', 'TagController@getTagBySentence')->name('tags.getTagBySentence');
Route::middleware(['admin'])->prefix('generalsetting')->group(function() {
    //analytics tool
    Route::get('/analytics', 'AnalyticsToolController@index')->name('setup.analytics.index')->middleware(['permission']);
    Route::post('/analytics/google-analytics-update', 'AnalyticsToolController@googleAnalyticsUpdate')->name('setup.google-analytics-update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/analytics/facebook-pixel-update', 'AnalyticsToolController@facebookPixelUpdate')->name('setup.facebook-pixel-update')->middleware(['permission','prohibited_demo_mode']);

});


Route::prefix('hr')->group(function(){
    Route::get('/departments', 'DepartmenController@index')->name('departments.index');
    Route::post('/departments-store', 'DepartmenController@store')->name('departments.store')->middleware('prohibited_demo_mode');
    Route::post('/departments-update', 'DepartmenController@update')->name('departments.update')->middleware('prohibited_demo_mode');
    Route::post('/departments-delete', 'DepartmenController@delete')->name('departments.delete')->middleware('prohibited_demo_mode');
});

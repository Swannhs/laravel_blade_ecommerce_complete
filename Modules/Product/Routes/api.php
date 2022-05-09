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



Route::prefix('product')->group(function () {
    //for category
    Route::resource('category', 'API\CategoryController')->only('index', 'show');
    Route::get('/category/filter/top', 'API\CategoryController@topCategory');

    //for brands
    Route::resource('brand', 'API\BrandController')->only('index', 'show');

    //for tags
    Route::resource('tag', 'API\TagController')->only('index', 'show');


});
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

Route::prefix('seller')->group(function () {

    Route::resource('products', 'API\ProductController')->only('index', 'show');
    Route::post('/product/get-sku-wise-price','API\ProductController@getSKUWisePrice');
    Route::get('/product/recomanded-product','API\ProductController@recomandedProduct');
    Route::get('/product/top-picks','API\ProductController@topPicks');
    Route::get('/product/sort-before-filter', 'API\ProductController@sortProductBeforeFilter');
    Route::post('/product/filter/filter-product-by-type','API\ProductController@filterProductByType');
    Route::post('/product/filter/filter-sort-product-by-type','API\ProductController@filterSortProductByType');
    Route::post('/product/filter/filter-product-page-by-type','API\ProductController@fetchFilterPagenateDataByType');

    //filter from all category product

    Route::post('/product/filter/category-filter-product','API\ProductController@filterProductByTypeGlobal');
    Route::get('/product/filter/fetch-data','API\ProductController@fetchDataGlobal');

    
    
});

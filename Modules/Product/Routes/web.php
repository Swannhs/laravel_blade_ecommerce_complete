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

Route::prefix('products')->as('product.')->group(function() {
    Route::middleware(['auth','seller'])->group(function() {
        Route::get('/', 'ProductController@index')->name('index')->middleware(['permission']);
        Route::get('/get-upsale-product-for-admin', 'ProductController@upsale_product');
        Route::get('/get-related-product-for-admin', 'ProductController@related_product');
        Route::get('/get-cross-sale-product-for-admin', 'ProductController@crosssale_product');
        Route::get('/request-get-data', 'ProductController@requestGetData')->name('request-get-data')->middleware(['permission']);
        Route::get('/get-data-sku', 'ProductController@skuGetData')->name('get-data-sku')->middleware(['permission']);
        Route::get('/create', 'ProductController@create')->name('create')->middleware(['permission']);
        Route::get('/{id}/edit', 'ProductController@edit')->name('edit')->middleware(['permission']);
        Route::get('/{id}/clone', 'ProductController@clone')->name('clone')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/show', 'ProductController@show')->name('show')->middleware('prohibited_demo_mode');
        Route::post('/store', 'ProductController@store')->name('store')->middleware('prohibited_demo_mode');
        Route::post('/update/{id}', 'ProductController@update')->name('update')->middleware('prohibited_demo_mode');
        Route::post('/destroy', 'ProductController@destroy')->name('destroy')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/meta-image-delete', 'ProductController@metaImgDelete')->name('meta-img-delete')->middleware('prohibited_demo_mode');
        Route::post('/sku-combination', 'ProductController@sku_combination')->name('sku_combination')->middleware('prohibited_demo_mode');
        Route::post('/sku-combination-edit', 'ProductController@sku_combination_edit')->name('sku_combination_edit')->middleware('prohibited_demo_mode');
        Route::post('/update-status', 'ProductController@update_status')->name('update_active_status')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/sku-status', 'ProductController@updateSkuStatusByID')->name('sku.status')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/sku-delete', 'ProductController@deleteSkuByID')->name('sku.delete')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/sku-edit', 'ProductController@updateSkuByID')->name('sku.update')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/get-attribute-values', 'AttributeController@attribute_values')->name('attribute.values');
        Route::get('bulk-product-upload', 'ProductController@bulk_product_upload_page')->name('bulk_product_upload_page')->middleware(['permission']);
        Route::post('bulk-product-upload-store', 'ProductController@bulk_product_store')->name('bulk_product_store')->middleware(['permission','prohibited_demo_mode']);
    });


    //Category
    Route::middleware(['auth','admin'])->group(function() {
        Route::resource('category', 'CategoryController')->except('destroy,update')->middleware(['permission']);
        Route::get('bulk-category-upload', 'CategoryController@bulk_category_upload_page')->name('bulk_category_upload_page')->middleware(['permission']);
        Route::get('download-category-list-csv', 'CategoryController@csv_category_download')->name('csv_category_download')->middleware(['permission']);
        Route::post('bulk-category-upload-store', 'CategoryController@bulk_category_store')->name('bulk_category_store')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/category/update','CategoryController@update')->name('category.update')->middleware('prohibited_demo_mode');
        Route::post('/category/delete','CategoryController@delete')->name('category.delete')->middleware(['permission','prohibited_demo_mode']);
        Route::get('/category-info','CategoryController@info')->name('categories.index_info')->middleware(['permission']);
        Route::get('/menu','CategoryController@newCategory')->name('menu');
        Route::get('/menu/setup','CategoryController@newCategorySetup')->name('menu.setup');


        Route::post('/request-product/approved', 'ProductController@approved')->name('request.approved')->middleware(['permission','prohibited_demo_mode']);
        Route::get('/recently-view-product-config', 'ProductController@recent_view_product_config')->name('recent_view_product_config');
        Route::post('/recently-view-product-config-update', 'ProductController@recent_view_product_config_update')->name('recent_view_product_config_update')->middleware('prohibited_demo_mode');
        Route::get('/recently-view-product-crone-job', 'ProductController@recently_view_product_cronejob')->name('recently_view_product_cronejob');
    });


    Route::middleware(['auth','admin'])->group(function() {
        Route::get('/brands-list', 'BrandController@index')->name('brands.index')->middleware(['permission']);
        Route::get('/brands-create', 'BrandController@create')->name('brand.create')->middleware(['permission']);
        Route::post('/brands-store', 'BrandController@store')->name('brand.store')->middleware('prohibited_demo_mode');
        Route::get('/brands-edit/{id}', 'BrandController@edit')->name('brand.edit')->middleware(['permission']);
        Route::post('/brands-update/{id}', 'BrandController@update')->name('brand.update')->middleware('prohibited_demo_mode');
        Route::get('/brands-destroy/{id}', 'BrandController@destroy')->name('brand.destroy')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/brands-update-status', 'BrandController@update_status')->name('brand.update_active_status')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/brands-update-feature', 'BrandController@update_feature')->name('brand.update_active_feature')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/brands/menu/update-order','BrandController@updateOrder')->name('brand.menuOrder')->middleware('prohibited_demo_mode');
        Route::post('/brandspost-sortable','BrandController@sortableUpdate')->name('abc');
        Route::post('load-more-brand', 'BrandController@load_more_brands')->name('load_more_brands')->middleware(['permission']);
        Route::get('bulk-brand-upload', 'BrandController@bulk_brand_upload_page')->name('bulk_brand_upload_page')->middleware(['permission']);
        Route::post('bulk-brand-upload-store', 'BrandController@bulk_brand_store')->name('bulk_brand_store')->middleware(['permission','prohibited_demo_mode']);
        Route::get('download-brand-list-csv', 'BrandController@csv_brand_download')->name('csv_brand_download')->middleware(['permission']);
    });


    Route::middleware(['auth','admin'])->group(function() {
        Route::get('/attribute-list', 'AttributeController@index')->name('attribute.index')->middleware(['permission']);
        Route::get('/attribute-get-list', 'AttributeController@get_list')->name('attribute.get_list')->middleware(['permission']);
        Route::get('/attribute-list/{id}/edit', 'AttributeController@edit')->name('attribute.edit')->middleware(['permission']);
        Route::post('/attribute-list/show', 'AttributeController@show')->name('attribute.show');
        Route::get('/attribute-destroy/{id}', 'AttributeController@destroy')->name('attribute.destroy')->middleware(['permission','prohibited_demo_mode']);
        Route::post('/attribute-list/{id}/update', 'AttributeController@update')->name('attribute.update')->middleware('prohibited_demo_mode');
        Route::post('/attribute-store', 'AttributeController@store')->name('attribute.store')->middleware(['permission','prohibited_demo_mode']);
    });

    Route::middleware(['auth','admin','permission'])->group(function() {
        Route::get('/units', 'UnitTypeController@index')->name('units.index');
        Route::get('/get-unit-list', 'UnitTypeController@get_list')->name('units.get_list');
        Route::post('/unit-store', 'UnitTypeController@store')->name('units.store')->middleware('prohibited_demo_mode');
        Route::post('/unit-update/{id}', 'UnitTypeController@update')->name('units.update')->middleware('prohibited_demo_mode');
        Route::get('/unit/destroy/{id}', 'UnitTypeController@destroy')->name('units.destroy')->middleware('prohibited_demo_mode');
        Route::get('download-unit-list-csv', 'UnitTypeController@csv_unit_download')->name('csv_unit_download');
    });

});

Route::get('/get-data', 'ProductController@getData')->name('product.get-data')->middleware(['auth','seller']);

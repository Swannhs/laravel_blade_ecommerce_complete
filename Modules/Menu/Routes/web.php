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

Route::middleware(['admin','permission'])->prefix('menu')->as('menu.')->group(function() {
    Route::get('/manage', 'MenuController@index')->name('manage');
    Route::post('/store', 'MenuController@store')->name('store')->middleware('prohibited_demo_mode');
    Route::post('/update', 'MenuController@update')->name('update')->middleware('prohibited_demo_mode');
    Route::post('/sort', 'MenuController@sort')->name('sort')->middleware('prohibited_demo_mode');
    Route::get('/edit', 'MenuController@edit')->name('edit');
    Route::post('/delete', 'MenuController@destroy')->name('delete')->middleware('prohibited_demo_mode');
    Route::post('/manage/status', 'MenuController@status')->name('status')->middleware('prohibited_demo_mode');


    Route::get('/setup/{id}', 'MenuController@setup')->name('setup');
    Route::post('/setup/add-column', 'MenuController@addColumn')->name('setup.add-column')->middleware('prohibited_demo_mode');
    Route::post('/setup/add-element', 'MenuController@addElement')->name('setup.add-element')->middleware('prohibited_demo_mode');
    Route::post('/setup/add-to-column', 'MenuController@addToColumn')->name('setup.add-to-column')->middleware('prohibited_demo_mode');
    Route::post('/setup/remove-from-column', 'MenuController@removeFromColumn')->name('setup.remove-from-column')->middleware('prohibited_demo_mode');
    Route::post('/setup/column/sort', 'MenuController@sortColumn')->name('setup.sort-column')->middleware('prohibited_demo_mode');
    Route::post('/setup/element/sort', 'MenuController@sortElement')->name('setup.sort-element')->middleware('prohibited_demo_mode');
    Route::post('/setup/column-delete', 'MenuController@columnDelete')->name('setup.column-delete')->middleware('prohibited_demo_mode');
    Route::post('/setup/element-delete', 'MenuController@elementDelete')->name('setup.element-delete')->middleware('prohibited_demo_mode');
    Route::post('/setup/column-update', 'MenuController@columnUpdate')->name('setup.column-update')->middleware('prohibited_demo_mode');

    Route::post('/setup/element-update', 'MenuController@elementUpdate')->name('setup.element-update')->middleware('prohibited_demo_mode');

    //for normal nestable menu
    Route::post('/setup/normal-menu/order', 'MenuController@NormalMenuOrder')->name('setup.normal-menu.order')->middleware('prohibited_demo_mode');

    //for multi mega menu
    Route::post('/setup/add-menu', 'MenuController@addMenu')->name('setup.add-menu')->middleware('prohibited_demo_mode');
    Route::post('/setup/sort-menu', 'MenuController@sortMenuForMultiMenu')->name('setup.sort-menu')->middleware('prohibited_demo_mode');
    Route::post('/setup/menu-delete', 'MenuController@deleteMenuForMultiMenu')->name('setup.menu-delete')->middleware('prohibited_demo_mode');
    Route::post('/setup/menu-update', 'MenuController@updateMenuForMultiMenu')->name('setup.menu-update')->middleware('prohibited_demo_mode');

    //for right panel setup
    Route::post('/setup/add-rightpanel-data', 'MenuController@addRightPanelData')->name('setup.add-rightpanel-data')->middleware('prohibited_demo_mode');
    Route::post('/setup/category-delete', 'MenuController@deleteRightPanelData')->name('setup.category-delete')->middleware('prohibited_demo_mode');
    Route::post('/setup/category-sort', 'MenuController@sortRightPanelData')->name('setup.category-sort')->middleware('prohibited_demo_mode');
    Route::post('/setup/rightpanel-data-update', 'MenuController@updateRightPanelData')->name('setup.rightpanel-data-update')->middleware('prohibited_demo_mode');

    //for bottom panel data
    Route::post('/setup/add-bottompanel-data', 'MenuController@addBottomPanelData')->name('setup.add-bottompanel-data')->middleware('prohibited_demo_mode');
    Route::post('/setup/brand-delete', 'MenuController@deleteBottomPanelData')->name('setup.brand-delete')->middleware('prohibited_demo_mode');
    Route::post('/setup/brand-sort', 'MenuController@sortBottomPanelData')->name('setup.brand-sort')->middleware('prohibited_demo_mode');
    Route::post('/setup/bottompanel-data-update', 'MenuController@updateBottomPanelData')->name('setup.bottompanel-data-update')->middleware('prohibited_demo_mode');
});

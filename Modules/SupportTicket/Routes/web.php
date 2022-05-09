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

//for backend user



Route::middleware(['admin'])->prefix('admin/ticket')->as('ticket.')->group(function() {

    Route::resource('tickets', 'SupportTicketController')->except('destroy')->middleware(['permission']);
    Route::get('/assigned-ticket','SupportTicketController@my_ticket')->name('my_ticket');
    Route::get('/assigned-ticket/get-data','SupportTicketController@my_ticket_get_data')->name('my_ticket_get_data');
    Route::get('/get-data','SupportTicketController@getData')->name('get-data');
    Route::get('/search','SupportTicketController@search')->name('data-search');
    Route::get('/search-assigned','SupportTicketController@searchAssigned')->name('data_search_assigned');
    Route::post('/delete','SupportTicketController@destroy')->name('tickets.destroy')->middleware('prohibited_demo_mode');

    Route::put('assign-user','SupportTicketController@assignedAgent')->name('assign.user')->middleware('prohibited_demo_mode');



    //category
    Route::get('/categories','SupportTicketCategoryController@index')->name('category.index')->middleware(['permission']);
    Route::post('/categories/store','SupportTicketCategoryController@store')->name('category.store')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/categories/edit','SupportTicketCategoryController@edit')->name('category.edit');
    Route::post('/categories/update','SupportTicketCategoryController@update')->name('category.update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/categories/delete','SupportTicketCategoryController@destroy')->name('category.delete')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/categories/status','SupportTicketCategoryController@status')->name('category.status')->middleware(['permission','prohibited_demo_mode']);

    //priorities
    Route::get('/priorities','TicketPriorityController@index')->name('priority.index')->middleware(['permission']);
    Route::post('/priorities/store','TicketPriorityController@store')->name('priority.store')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/priorities/edit','TicketPriorityController@edit')->name('priority.edit');
    Route::post('/priorities/update','TicketPriorityController@update')->name('priority.update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/priorities/delete','TicketPriorityController@destroy')->name('priority.delete')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/priorities/status','TicketPriorityController@status')->name('priority.status')->middleware(['permission','prohibited_demo_mode']);

    //status
    Route::get('/status','TicketStatusController@index')->name('status.index')->middleware(['permission']);
    Route::post('/status/store','TicketStatusController@store')->name('status.store')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/status/edit','TicketStatusController@edit')->name('status.edit');
    Route::post('/status/update','TicketStatusController@update')->name('status.update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/status/delete','TicketStatusController@destroy')->name('status.delete')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/status/status','TicketStatusController@status')->name('status.status')->middleware(['permission','prohibited_demo_mode']);

});

Route::middleware(['auth'])->prefix('admin/ticket')->as('ticket.')->group(function() {
    Route::post('/attach-file-delete','SupportTicketController@attachFileDelete')->name('attach-file-delete')->middleware('prohibited_demo_mode');

    Route::post('message','TicketMessageController@store')->name('message')->middleware('prohibited_demo_mode');
});

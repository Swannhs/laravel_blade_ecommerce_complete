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

Route::prefix('attendance')->group(function () {
    Route::get('/', 'AttendanceController@index')->name('attendances.index')->middleware(['admin']);
    Route::post('/store', 'AttendanceController@store')->name('attendances.store')->middleware(['admin','prohibited_demo_mode']);
    Route::prefix('attendance')->middleware(['admin'])->group(function () {
        Route::get('/', 'AttendanceController@index');
    });

    Route::prefix('hr')->group(function () {
        Route::group(['prefix' => '/attendance'], function () {
            Route::get('/', 'AttendanceController@index')->name('attendances.index')->middleware(['admin','permission']);
            Route::post('/store', 'AttendanceController@store')->name('attendances.store')->middleware(['admin','permission','prohibited_demo_mode']);

            // Attendance Report Controller
            Route::get('/report-index', 'AttendanceReportController@index')->name('attendance_report.index')->middleware(['admin','permission']);
        });

    });

    Route::resource('holidays', 'HolidayController')->middleware(['admin','permission']);
    Route::post('/add-row', 'HolidayController@addRow')->name('add.row')->middleware('prohibited_demo_mode');
    Route::get('/last-year-data/{year}', 'HolidayController@getLastYearData')->name('last.year.data')->middleware(['admin','permission']);

    Route::prefix('attendance')->middleware(['admin'])->group(function () {

        Route::post('/get-user-by-role', 'AttendanceController@get_user_by_role')->name('get_user_by_role');


        Route::get('/report-index/search', 'AttendanceReportController@reports')->name('attendance_report.search');
        Route::get('/attendence-report-print/{role_id}/{month}/{year}', 'AttendanceReportController@attendance_report_print')->name('attendance_report_print');
    });
});
Route::resource('to_dos','ToDoController');
Route::get('complete-to-do','ToDoController@completeToDo');
Route::get('get-to-do-list','ToDoController@completeList');
Route::resource('events','EventController')->middleware(['admin','permission']);
Route::get('events-delete/{id}','EventController@destroy')->name('events.delete')->middleware(['admin','permission']);

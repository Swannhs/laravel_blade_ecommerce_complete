<?php

use Illuminate\Support\Facades\Route;

Route::prefix('account')->middleware('admin')->as('account.')->group(function() {
    Route::resource('chart-of-accounts', 'ChartOfAccountController')->middleware(['permission']);
    Route::resource('incomes', 'IncomeController')->middleware(['permission']);
    Route::resource('expenses', 'ExpenseController')->middleware(['permission']);
    Route::resource('bank-accounts', 'BankAccountController')->middleware(['permission']);
    Route::get('profit', 'ReportController@profit')->name('profit')->middleware(['permission']);
    Route::get('transaction', 'ReportController@transaction')->name('transaction')->middleware(['permission']);
    Route::get('transaction-get-dtbl', 'ReportController@transaction_dtbl')->name('transaction_dtbl')->middleware(['permission']);
    Route::get('statement', 'ReportController@statement')->name('statement')->middleware(['permission']);
    Route::get('statement-get-dtbl', 'ReportController@statement_dtbl')->name('statement_dtbl')->middleware(['permission']);
    Route::get('bank-report/{id}', 'ReportController@bankStatement')->name('bank.statement')->middleware(['permission']);
});

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

Route::middleware(['auth','admin'])->prefix('generalsetting')->group(function () {
    Route::get('/', 'GeneralSettingController@index')->name('generalsetting.index')->middleware(['permission']);
    Route::get('/activation', 'GeneralSettingController@activation_index')->name('generalsetting.activation_index');
    Route::get('/sms-setting', 'GeneralSettingController@sms_index')->name('generalsetting.sms_index');
    Route::get('/smtp-setting', 'GeneralSettingController@smtp_index')->name('generalsetting.smtp_index');
    Route::get('/company-info', 'GeneralSettingController@company_index')->name('generalsetting.company_index');
    Route::post('/update-activation-status', 'GeneralSettingController@update_activation_status')->name('update_activation_status')->middleware(['permission','prohibited_demo_mode']);

    Route::post('general-settings/update', 'GeneralSettingController@update')->name('company_information_update')->middleware(['permission','prohibited_demo_mode']);

    Route::post('sms-gateway-credentials/update', 'GeneralSettingController@sms_gateway_credentials_update')->name('sms_gateway_credentials_update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('smtp-gateway-credentials/update', 'GeneralSettingController@smtp_gateway_credentials_update')->name('smtp_gateway_credentials_update')->middleware(['permission','prohibited_demo_mode']);

    Route::post('sms-demo-send', 'GeneralSettingController@sms_send_demo')->name('sms_send_demo');
    Route::post('/test-mail/send', 'GeneralSettingController@test_mail_send')->name('test_mail.send');

    Route::post('/email-template', 'GeneralSettingController@emailTemplate')->name('generalsetting.email-template.update')->middleware('prohibited_demo_mode');
    Route::get('/import', 'GeneralSettingController@import')->name('generalsetting.import')->middleware('prohibited_demo_mode');

    Route::post('/footer-update', 'GeneralSettingController@footer_update')->name('generalsetting.footer_update')->middleware('prohibited_demo_mode');
    // Notification Setting
    Route::get('/notification', 'NotificationSettingController@index')->name('notificationsetting.index')->middleware(['permission']);
    Route::get('/notification/{id}', 'NotificationSettingController@edit')->name('notificationsetting.edit')->middleware(['permission']);
    Route::post('/notification/{id}', 'NotificationSettingController@update')->name('notificationsetting.update')->middleware(['permission','prohibited_demo_mode']);
    //User Notification Setting

    //maintenance mode
    Route::get('/maintenance-mode', 'MaintenanceController@index')->name('maintenance.index');
    Route::post('/maintenance-mode', 'MaintenanceController@maintenanceAction')->name('maintenance.update')->middleware('prohibited_demo_mode');

    Route::get('/maintenance-mode', 'MaintenanceController@index')->name('maintenance.index')->middleware(['permission']);
    Route::post('/maintenance-mode', 'MaintenanceController@maintenanceAction')->name('maintenance.update')->middleware(['permission','prohibited_demo_mode']);

    // update system
    Route::get('/update-system', 'UpdateController@updatesystem')->name('generalsetting.updatesystem')->middleware(['permission']);
    Route::post('/update-system', 'UpdateController@updatesystemsubmit')->name('generalsetting.updatesystem.submit')->middleware(['permission','prohibited_demo_mode']);

        // Social configurateion
    Route::get('/social_login_configuration', 'SocialConfigController@social_login_configuration')->name('generalsetting.social_login_configuration');
    Route::post('/social_login_configuration', 'SocialConfigController@social_login_configuration_update')->name('generalsetting.social_login_configuration.update')->middleware('prohibited_demo_mode');
    Route::post('/social_messanger_chat_configuration', 'SocialConfigController@messangerChatUpdate')->name('generalsetting.messangerChat.update')->middleware('prohibited_demo_mode');


});

Route::get('/generalsetting/user-notification', 'UserNotificationSettingController@index')->name('user.notificationsetting.index');
Route::post('/generalsetting/user-notification/{id}', 'UserNotificationSettingController@update')->name('user.notificationsetting.update')->middleware('prohibited_demo_mode');


Route::middleware(['auth','admin'])->prefix('setup')->group(function () {
    Route::get('currencies', 'CurrencyController@index')->name('currencies.index')->middleware(['permission']);
    Route::post('currencies', 'CurrencyController@store')->name('currencies.store')->middleware(['permission','prohibited_demo_mode']);
    Route::put('currencies/{id}', 'CurrencyController@update')->name('currencies.update')->middleware(['permission','prohibited_demo_mode']);
    Route::get('currencies/{id}', 'CurrencyController@index')->name('currencies.show');
    Route::post('currency-edit-modal', 'CurrencyController@edit_modal')->name('currencies.edit');
    Route::get('/currencies/destroy/{id}', 'CurrencyController@destroy')->name('currencies.destroy')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/currency-active-status', 'CurrencyController@update_active_status')->name('currencies.update_active_status')->middleware(['permission','prohibited_demo_mode']);
});

Route::middleware(['auth','admin'])->prefix('generalsetting')->group(function () {
    Route::get('email-templates', 'EmailTemplateController@index')->name('email_templates.index')->middleware(['permission']);
    Route::get('email-templates/create', 'EmailTemplateController@create')->name('email_templates.create')->middleware(['permission']);
    Route::get('email-templates/{id}/manage', 'EmailTemplateController@show')->name('email_templates.manage')->middleware(['permission']);
    Route::post('email-templates/store', 'EmailTemplateController@store')->name('email_templates.store')->middleware(['permission','prohibited_demo_mode']);
    Route::post('email-templates/{id}/update', 'EmailTemplateController@update')->name('email_templates.update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('email-templates/update-activate-status', 'EmailTemplateController@update_status')->name('email_templates.update_status')->middleware(['permission','prohibited_demo_mode']);

    Route::get('sms-templates', 'SMSTemplateController@index')->name('sms_templates.index')->middleware(['permission']);
    Route::get('sms-templates/create', 'SMSTemplateController@create')->name('sms_templates.create')->middleware(['permission']);
    Route::get('sms-templates/{id}/manage', 'SMSTemplateController@edit')->name('sms_templates.manage')->middleware(['permission']);
    Route::post('sms-templates/store', 'SMSTemplateController@store')->name('sms_templates.store')->middleware(['permission','prohibited_demo_mode']);
    Route::post('sms-templates/{id}/update', 'SMSTemplateController@update')->name('sms_templates.update')->middleware(['permission','prohibited_demo_mode']);
    Route::post('sms-templates/update-activate-status', 'SMSTemplateController@update_status')->name('sms_templates.update_status')->middleware(['permission','prohibited_demo_mode']);
});



Route::middleware(['auth','admin'])->prefix('generalsetting')->group(function () {
    Route::get('file-storage/setting', 'CloudStorageController@index')->name('file-storage.index')->middleware(['permission','prohibited_demo_mode']);
});





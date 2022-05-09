<?php

Route::group(['prefix' => 'api', 'namespace' => 'SpondonIt\Service\Controllers\Api',], function(){
	Route::get('service/check', 'CheckController@index');
});
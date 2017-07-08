<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/home', function () {
		return redirect('/');
	});


	Route::resource('antMiners', 'AntMinerController');

});



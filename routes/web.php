<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/home', 'HomeController@index')->name('home');

});


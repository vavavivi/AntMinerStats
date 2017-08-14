<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/home', function () {
		return redirect('/');
	});

    Route::get('/antMiners/{antMiner}/log_old', 'LogController@show_old')->name('log.show_old');
    Route::get('/antMiners/{antMiner}/log', 'LogController@show')->name('log.show');

	Route::resource('antMiners', 'AntMinerController');
	;

});



<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/home', function () {
		return redirect('/');
	});

	Route::get('/profile', 'HomeController@getProfile')->name('profile');
	Route::post('/profile', 'HomeController@postProfile')->name('profile');

	Route::post('/antMiners/view', 'AntMinerController@view')->name('antMiners.view');
	Route::get('/antMiners/{antMiner}/desc', 'AntMinerController@set_desc')->name('antMiners.desc');
	Route::get('/antMiners/{antMiner}/asc', 'AntMinerController@set_asc')->name('antMiners.asc');
	Route::get('/antMiners/{antMiner}/enable', 'AntMinerController@state')->name('antMiners.state');
	Route::post('/antMiners/force', 'AntMinerController@force')->name('antMiners.force');

    Route::get('/antMiners/{antMiner}/log_old', 'LogController@show_old')->name('log.show_old');
    Route::get('/antMiners/{antMiner}/log', 'LogController@show')->name('log.show');

	Route::resource('antMiners', 'AntMinerController');

	Route::get('/alerts/{alert}/read', 'AlertController@read')->name('alerts.read');
	Route::post('/alerts/purge', 'AlertController@purge')->name('alerts.purge');
	Route::resource('alerts', 'AlertController');

	Route::resource('locations', 'LocationController');
	//Route::resource('faq', 'FaqController');

	Route::get('/faq', 'FaqController@index')->name('faq.index');
});


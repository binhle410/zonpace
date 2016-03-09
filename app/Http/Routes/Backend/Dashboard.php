<?php

Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

Route::resource('page', 'PageController');

Route::resource('booking', 'BookingController');
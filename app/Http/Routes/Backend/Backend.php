<?php

Route::group(['namespace' => 'Auth'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'AuthController@showLoginForm')
            ->name('backend.auth.login');
        Route::post('login', 'AuthController@login')
            ->name('backend.post-login');

        Route::get('password/reset/{token?}', 'PasswordController@showResetForm')
            ->name('backend.password.reset');
        Route::post('password/email', 'PasswordController@sendResetLinkEmail')
            ->name('backend.password.post-email');
        Route::post('password/reset', 'PasswordController@reset')
            ->name('backend.password.post-reset');
    });
});

Route::get('profile', 'ProfileController@index')->name('backend.profile');
Route::post('profile', 'ProfileController@update')->name('backend.profile.update');
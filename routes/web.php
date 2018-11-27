<?php

Route::middleware('guest')->group(function() {
    Route::get('/', 'AuthController@showLogin')->name('login');
    Route::post('/auth/login', 'AuthController@login')->name('authenticate');
});

Route::get('/auth/logout', 'AuthController@logout')->name('logout');

Route::middleware('auth')->group(function() {
    Route::get('/download', 'SampleController@download');
    Route::get('/admin{any}', 'HomeController@index')
        ->name('admin')
        ->where(['any' => '.*']);
});

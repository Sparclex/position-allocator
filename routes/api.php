<?php

use Illuminate\Http\Request;


Route::get('samples', 'SampleController@index')->middleware('auth');
Route::post('samples', 'SampleController@store')->middleware('auth');
Route::delete('samples/all', 'SampleController@destroyAll')->middleware('auth');
Route::delete('samples/{sample}', 'SampleController@destroy')->middleware('auth');

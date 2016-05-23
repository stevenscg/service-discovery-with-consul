<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demos/dns',      'DemosController@dns')->name('demos.dns');
Route::get('/demos/api',      'DemosController@api')->name('demos.api');
Route::get('/demos/kv',       'DemosController@kv')->name('demos.kv');
Route::get('/demos/locks',    'DemosController@locks')->name('demos.locks');
Route::get('/demos/features', 'DemosController@features')->name('demos.features');

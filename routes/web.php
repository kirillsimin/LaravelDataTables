<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '/'], function () {
    Route::get('/', ['uses' => 'BandController@index', 'as' => 'bands.index']);
});

Route::group(['prefix' => 'albums'], function () {
    Route::get('/', ['uses' => 'AlbumController@index', 'as' => 'albums.index']);
});

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

Route::group(['prefix' => '/bands'], function() {
    Route::get('/data', ['uses' => 'BandController@data']);
    Route::get('/edit/{id}', ['uses' => 'BandController@edit', 'as' => 'band.edit']);
    Route::post('/delete', ['uses' => 'BandController@delete', 'as' => 'band.delete']);
    Route::post('/search', ['uses' => 'BandController@search']);
});

Route::group(['prefix' => 'albums'], function () {
    Route::get('/', ['uses' => 'AlbumController@index', 'as' => 'albums.index']);
    Route::get('/data', ['uses' => 'AlbumController@data']);
    Route::get('/edit/{id}', ['uses' => 'AlbumController@edit', 'as' => 'album.edit']);
    Route::post('/delete', ['uses' => 'AlbumController@delete', 'as' => 'album.delete']);
});

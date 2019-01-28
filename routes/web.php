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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users-upload', function () {
    return view('users-upload.index');
});

Route::post('/users-import','UserController@import')->name('import');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

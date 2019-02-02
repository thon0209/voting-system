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

// Route::get('/users-upload', function () {
//     return view('users-upload.index');
// });

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/voting', function () {
        return view('voting.index');
    });
    Route::get('/setting/election', function () {
        return view('settings.election.index');
    });
    Route::get('/setting/candidate', function () {
        return view('settings.candidate.index');
    });

});







Route::get('/home', 'HomeController@index')->name('home');


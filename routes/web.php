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



// Route::get('/users-upload', function () {
//     return view('users-upload.index');
// });

Auth::routes();
// Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

    Route::get('/', function () {
        return view('auth.login');
    });

Route::middleware(['auth'])->group(function () {

    Route::get('/voting', function () {
        return view('voting.index');
    });
    Route::get('/vote-done', function () {
        return view('vote-done.index');
    });
    Route::get('/polling-results', function () {
        return view('polling.index');
    });
    Route::get('/vote-log', function () {
        return view('vote-logs.index');
    });
    
    //Settings
    Route::get('/setting/candidate', function () {
        return view('settings.candidate.index');
    });
    Route::get('/setting/election', function () {
        return view('settings.election.index');
    });
    Route::get('/setting/party', function () {
        return view('settings.party.index');
    });
    Route::get('/setting/position', function () {
        return view('settings.position.index');
    });
    Route::get('/setting/user', function () {
        return view('settings.user.index');
    });

});

//Route::get('/home', 'HomeController@index')->name('home');


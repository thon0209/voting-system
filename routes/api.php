<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



//Position
Route::resource('positions','PositionController');
Route::get('/get-position','PositionController@getPosition');
//PartyList
Route::resource('parties','PartyListController');
Route::get('/get-party','PartyListController@getParty');
//Election
Route::resource('elections','ElectionController');
Route::get('/get-election','ElectionController@getActiveElection');
//Candidates
Route::resource('candidates','CandidateController');
//Users
Route::resource('users','UserController');
Route::post('/user-upload','UserController@import');
//Voting
Route::resource('voting','PollingController');

//Polling Results
Route::get('polling','PollingController@getResults');
//Polling Log
Route::get('polling-log','PollingController@index');


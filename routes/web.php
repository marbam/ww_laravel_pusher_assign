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

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['approved'])->group(function () {
    Route::get('/games', 'ModController@gamesList');
    Route::get('/new_game', 'ModController@newGame');
    Route::post('/setup_game', 'ModController@submitGame');
    Route::get('/game/{game}', 'ModController@setupGame');
    Route::get('/get_players/{game}', 'ModController@getPlayers');
    Route::get('/get_factions/{game}', 'ModController@getGameSetupData');
    Route::post('mod_update/{game}', 'ModController@updateGame');
});

Route::get('/join', 'PlayerController@join');
Route::post('/join_game', 'PlayerController@submitPlayer');
Route::get('/room/{game}', 'PlayerController@waiting');
Route::get('factions_in_game/{game}', 'PlayerController@getFactions');

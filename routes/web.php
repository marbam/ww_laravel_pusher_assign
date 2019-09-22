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

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::middleware(['approved'])->group(function () {
    Route::get('/games', 'ModController@gamesList');
    Route::get('/new_game', 'ModController@newGame');
    Route::post('/setup_game', 'ModController@submitGame');
    Route::get('/game/{game}', 'ModController@setupGame');
    Route::get('/get_players/{game}', 'ModController@getPlayers');
    Route::get('/get_factions/{game}', 'ModController@getGameSetupData');
    Route::post('/mod_update/{game}', 'ModController@updateGame');
    Route::get('/close/{game}', 'ModController@closeGame');
    Route::get('/allocate/{game}', 'ModController@allocateScreen');
    Route::post('/final_allocation/{game}', 'ModController@autoAllocate');
    if (ENV('APP_DEBUG')) {
        Route::get('/add_test_players/{game_id}', 'PlayerController@addTestPlayers');
        Route::get('/add_test_players/{game_id}/{number}', 'PlayerController@addTestPlayersV2');
    }
});

Route::get('/join', 'PlayerController@join');
Route::post('/join_game', 'PlayerController@submitPlayer');
Route::get('/room/{game}', 'PlayerController@waiting');
Route::get('/factions_in_game/{game}', 'PlayerController@getFactions');
Route::get('/roles_ready', 'PlayerController@roleReveal');
Route::get('/reset-player', 'PlayerController@resetPlayer');

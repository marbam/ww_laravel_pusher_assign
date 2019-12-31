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
    // modifiers
    Route::post('/game_has_modifiers/{game}', 'ModController@permitModifiers');
    Route::get('/configure_modifiers/{game}', 'ModController@configureModifiers');
    Route::post('/add_modifier/{game}', 'ModController@addModifier');
    Route::post('/remove_modifier/{game}', 'ModController@removeModifier');
    Route::get('/apply_modifiers/{game}', 'ModController@applyModifiers');
    Route::post('/get_role_div/{position}', 'ModController@returnModifierPartial');
    Route::post('/allocate_modifier/{game}', 'ModController@allocateModifier');
    Route::post('/deallocate_modifier/{game}', 'ModController@deAllocateModifier');

    // end modifiers
    Route::get('/allocate/{game}', 'ModController@allocateScreen');
    Route::post('/final_allocation/{game}', 'ModController@autoAllocate');
    Route::get('/users', 'UserController@getListing');
    Route::post('/update_users', 'UserController@updateUsers');
    Route::get('/user_delete/{user}', 'UserController@deleteUser');
    Route::post('/add_phoneless/{game}', 'ModController@addNoPhone');
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
Route::get('/awaiting_approval', 'UserController@awaitingApproval');

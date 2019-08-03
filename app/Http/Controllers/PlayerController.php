<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Game;
use App\Maybe;
use App\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\PlayerCreated;
use App\Http\Requests\JoinGameRequest;

class PlayerController extends Controller
{
    public function join()
    {
        return view('player.join');
    }

    public function submitPlayer(JoinGameRequest $request)
    {
        $game = Game::where('code', $request['code'])->first();

        if (!$game) {
        	return abort(404);
        }

        $listingOrder = Player::where('game_id', $game->id)->max('listing_order');
        if(!$listingOrder) {
            $listingOrder = 1;
        } else {
            $listingOrder++;
        }

        $player = Player::create([
            'game_id' => $game->id,
            'name' => $request['name'],
            'listing_order' => $listingOrder
        ]);

        // set session when you enter the room
        session(['game_id' => $game->id]);
        session(['player_id' => $player->id]);
        PlayerCreated::dispatch($player, $game->id);

        return redirect('/room/'.$game->id);
    }

    public function waiting(Game $game) 
    {
        if (is_null(session('game_id')) || session('game_id') != $game->id) {
            abort(403);
        }

        return view('player.waiting_room', ['game_id' => $game->id]);
    }

    public function getFactions(Game $game) 
    {
        $factions[] = "One Moon";
        $temp = Maybe::where('game_id', $game->id)
                       ->join('factions', 'maybes.faction_id', '=', 'factions.id')
                       ->pluck('factions.name')
                       ->toArray();

        return array_merge($factions, $temp);
    }

    public function roleReveal() 
    {
        $player = Player::with(['role', 'role.faction'])->find(session('player_id'));
        return view('player.role_reveal', ['player' => $player]);
    }

    public function addTestPlayers($gameId) 
    {
        $playerNames = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10,];
        foreach ($playerNames as $name) {
            $player = Player::create([
                'game_id' => $gameId,
                'name' => "Player ".$name,
                'listing_order' => $name
            ]);

            PlayerCreated::dispatch($player, $gameId);
        }
    }

    public function resetPlayer()
    {
        Session::forget('game_id');
        Session::forget('player_id');
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\Maybe;
use App\Player;
use Carbon\Carbon;
use App\Events\PlayerCreated;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function join()
    {
        return view('player.join');
    }

    public function submitPlayer(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|exists:games|max:20',
            'name' => 'required|max:20|notInGame',
        ]);

        $game = Game::where('code', $validatedData['code'])->first();

        if (!$game) {
        	return abort(404);
        }

        $player = Player::create([
        	'game_id' => $game->id,
        	'name' => $validatedData['name']
        ]);

        PlayerCreated::dispatch($player);

        return redirect('/room/'.$game->id);
    }

    public function waiting(Game $game) {
        return view('player.waiting_room', ['id' => $game->id]);
    }

    public function getFactions(Game $game) {
        $factions[] = "One Moon";
        $temp = Maybe::where('game_id', $game->id)
                       ->join('factions', 'maybes.faction_id', '=', 'factions.id')
                       ->pluck('factions.name')
                       ->toArray();

        return array_merge($factions, $temp);
    }
}

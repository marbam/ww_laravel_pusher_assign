<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ModController extends Controller
{
    public function gamesList()
    {
        $twentyFourHours = Carbon::now()->subHours(24);
        Game::where('created_at', '<', $twentyFourHours)->delete();

        $games = Game::where('moderator_id', Auth::id())
                     ->orderBy('created_at', 'DESC')
                     ->get();

        return view('mod.games', ['games' => $games]);
    }

    public function newGame()
    {
        return view('mod.new_game');
    }

    public function submitGame(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:games|max:20',
        ]);

        $new = Game::create([
            'code' => $validatedData['code'],
            'moderator_id' => Auth::id()
        ]);

        return redirect("/game/$new->id");
    }

    public function setupGame(Game $game)
    {
        $players = Player::where('game_id', $game->id)->get();
        return view('mod.build');
    }

    public function getPlayers(Game $game)
    {
        return Player::where('game_id', $game->id)->pluck('name');
    }
}

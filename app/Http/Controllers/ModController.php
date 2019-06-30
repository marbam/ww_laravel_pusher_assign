<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\Role;
use App\Player;
use App\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ModController extends Controller
{
    public function gamesList()
    {
        $twentyFourHours = Carbon::now()->subHours(24);
        Position::where('created_at', '<', $twentyFourHours)->delete();
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

        $rolesToAdd = Role::whereIn('name', ['Clairvoyant', 'Alpha Wolf'])->pluck('id');
        foreach ($rolesToAdd as $role) {
            Position::create([
                'game_id' => $new->id,
                'role_id' => $role
            ]);
        }

        return redirect("/game/$new->id");
    }

    public function setupGame(Game $game)
    {
        $gameData = $this->getGameSetupData($game);
        return view('mod.build', ['id' => $game->id, 'data' => $gameData]);
    }

    public function getPlayers(Game $game)
    {
        return Player::where('game_id', $game->id)->pluck('name');
    }

    public function getGameSetupData(Game $game) {
        $factions = \App\Faction::with(['roles' => function($roles) {
                                    $roles->orderBy('r_order');
                                }])
                                ->orderBy('f_order')
                                ->get();

        $alreadyIn = Position::where('game_id', $game->id)
                             ->pluck('role_id')->toArray();

        foreach ($factions as $faction) {
            foreach($faction->roles as $role) {
                $role->already_in = 0;
                if (in_array($role->id, $alreadyIn)) {
                    $role->already_in = 1;
                }
            }
        }

        return $factions;
    }
}

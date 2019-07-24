<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\Role;
use App\Maybe;
use App\Player;
use App\Faction;
use App\Position;
use Carbon\Carbon;
use App\Events\GameUpdated;
use Illuminate\Http\Request;

class ModController extends Controller
{
    public function gamesList()
    {
        $twentyFourHours = Carbon::now()->subHours(24);
        Position::where('created_at', '<', $twentyFourHours)->delete();
        Maybe::where('created_at', '<', $twentyFourHours)->delete();
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
        // get the number of players in the game, list of players and number of roles in the game.
        $players = Player::where('game_id', $game->id)->pluck('name');
        $rolesCount = Position::where('game_id', $game->id)->count();
        $data = ['players' => [], 'roles' => $rolesCount];
        if ($players->count()) {
            $data['players'] = $players;
        }
        return $data;
    }

    public function getGameSetupData(Game $game) {
        $factions = \App\Faction::with(['roles' => function($roles) {
                                    $roles->orderBy('r_order');
                                }])
                                ->orderBy('f_order')
                                ->where('show_in_listing', 1)
                                ->get();

        $alreadyIn = Position::where('game_id', $game->id)
                             ->pluck('role_id')->toArray();

        $maybeIn = Maybe::where('game_id', $game->id)
                             ->pluck('faction_id')->toArray();


        foreach ($factions as $faction) {
            foreach($faction->roles as $role) {
                $role->already_in = 0;
                if (in_array($role->id, $alreadyIn)) {
                    $role->already_in = 1;
                }
                $role->maybe_in = 0;
                if (in_array($role->faction_id, $maybeIn)) {
                    $role->maybe_in = 1;
                }

            }
        }

        return ['factions' => $factions, 'game_id' => $game->id];
    }

    public function updateGame(Request $request, Game $game) {
        $r = $request->all();
        if ($r['announceState']) { // if a faction is to be added or removed
            $role = Role::find($r['announceId']);

            $announced_faction = null;
            if ($role->notification_faction_id) {
                $announced_faction = Faction::find($role->notification_faction_id);
            }

            // if it's still null, it's not meant to be announced to the village, so skip everything below:
            // (e.g. don't announce village or wolf pack - they're covered by the one moon stuff)
            if ($announced_faction) {
                $count = Maybe::where([
                    'game_id' => $game->id,
                    'faction_id' => $announced_faction->id
                ])->count();

                // add or remove from the player list accordingly.
                if ($r['announceState'] == "add") {
                    Maybe::firstOrCreate([
                        'game_id' => $game->id,
                        'role_id' => $role->id,
                        'faction_id' => $announced_faction->id
                    ]);
                    if ($count == 0 && $role->moons != 1) {
                        GameUpdated::dispatch('add', $announced_faction->name);
                    }
                } else if ($r['announceState'] == "remove"){ // should always be remove, but cover our bases.
                    Maybe::where([
                        'game_id' => $game->id,
                        'role_id' => $role->id,
                        'faction_id' => $announced_faction->id
                    ])->delete();

                    if ($count == 1 && $role->moons != 1) { // last one
                        GameUpdated::dispatch('remove', $announced_faction->name);
                    }
                }
            }
        }

        if ($r['roleState']) {

            // add or remove from the game positions accordingly.
            if ($r['roleState'] == "add") {
                Position::create([
                    'game_id' => $game->id,
                    'role_id' => $r['roleId']
                ]);
            } else {
                Position::where([
                    'game_id' => $game->id,
                    'role_id' => $r['roleId']
                ])->delete();
            }
        }


    }
}

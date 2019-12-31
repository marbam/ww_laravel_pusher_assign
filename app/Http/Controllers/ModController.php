<?php

namespace App\Http\Controllers;

use Auth;
use App\Game;
use App\Role;
use App\Maybe;
use App\Player;
use App\Faction;
use App\Position;
use App\Modifier;
use App\GameModifier;
use Carbon\Carbon;
use App\Events\GameUpdated;
use Illuminate\Http\Request;
use App\Http\Requests\NewGameRequest;

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

    public function submitGame(NewGameRequest $request)
    {
        $new = Game::create([
            'code' => $request['code'],
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

        return ['factions' => $factions, 'game_id' => $game->id, 'alreadyIn' => sizeof($alreadyIn), 'game' => $game];
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
                        GameUpdated::dispatch('add', $announced_faction->name, $game->id);
                    }
                } else if ($r['announceState'] == "remove"){ // should always be remove, but cover our bases.
                    Maybe::where([
                        'game_id' => $game->id,
                        'role_id' => $role->id,
                        'faction_id' => $announced_faction->id
                    ])->delete();

                    if ($count == 1 && $role->moons != 1) { // last one
                        GameUpdated::dispatch('remove', $announced_faction->name, $game->id);
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

    public function permitModifiers(Request $request, Game $game)
    {
        $game->update(['has_modifiers' => $request->has_modifiers]);
    }

    public function configureModifiers(Game $game)
    {
        return view('mod.modifiers.add_modifiers', ['id' => $game->id]);
    }

    public function closeGame(Game $game)
    {
        $game->closed = 1;
        $game->save();
        if ($game->has_modifiers) {
            return redirect('/configure_modifiers/'.$game->id);
        }
        return redirect('/allocate/'.$game->id);
    }

    public function addModifier(Request $request, Game $game)
    {
        $added = GameModifier::create([
            'game_id' => $game->id,
            'modifier_id' => $request->modifier_id
        ]);

        return $added->id;
    }

    public function removeModifier(Request $request, Game $game)
    {
        GameModifier::where('id', $request->id)->delete();
    }

    public function applyModifiers(Game $game)
    {
        $modifiers = GameModifier::where('game_id', $game->id)
                                 ->join('modifiers', 'game_modifiers.modifier_id', '=', 'modifiers.id')
                                 ->orderBy('id')
                                 ->get([
                                     'game_modifiers.id',
                                     'game_modifiers.modifier_id',
                                     'modifiers.name',
                                     'game_modifiers.position_id'
                                 ]);
        $positions = Position::where('game_id', $game->id)->pluck('id');
        return view('mod.modifiers.apply_modifiers', ['id' => $game->id, 'modifiers' => $modifiers, 'positions' => $positions]);
    }

    public function returnModifierPartial(Position $position)
    {
        return view('mod.modifiers.role', ['position_id' => $position->id, 'id' => $position->game_id]);
    }

    public function allocateModifier(Request $request, Game $game)
    {
        $modifier = GameModifier::find($request->modifier_id);
        $modifier->update(['position_id' => $request->positionId]);
    }

    public function deAllocateModifier(Request $request, Game $game)
    {
        $modifier = GameModifier::find($request->modifier_id);
        $modifier->update(['position_id' => null]);
    }

    public function saveNotes(Request $request) {
        $position = Position::find($request->positionId);
        $position->update([
            'notes_from_mod' => $request->notes
        ]);
    }


    public function allocateScreen(Game $game)
    {
        $data['game'] = $game;
        // these guys will be used to populate the manual allocation screen - coming later.
        // $data['rolesIn'] = Position::where('game_id', $game->id)->get();
        // $data['roles'] = Role::get();
        $data['players'] = Player::where('game_id', $game->id)->get();
        return view('mod.allocate', ['data' => $data]);
    }

    public function autoAllocate(Request $request, Game $game)
    {
        $r = $request->all();
        unset($r['_token']);
        $updatedOrders = [];
        foreach ($r as $player => $playerId) {
            $exploded = explode("__", $player);
            $updatedOrders[$exploded[1]] = $playerId;
        }

        $positions = Position::where('game_id', $game->id)->get();
        $players = Player::where('game_id', $game->id)->whereNull('allocated_role_id')->get();

        if ($players->count() > 0) {
            foreach ($positions as $position) {
                // get a random player from the game's players collection
                $players = $players->where('allocated_role_id', '=', null);
                $player = $players->random();

                if ($game->has_modifiers) {
                    // get any modifiers associated with the position
                    $modifiers = GameModifier::where('position_id', $position->id)
                                             ->join('modifiers', 'game_modifiers.modifier_id', '=', 'modifiers.id')
                                             ->get([
                                                 'game_modifiers.id',
                                                 'player_id',
                                                 'modifier_id',
                                                 'is_corrupt',
                                                 'faction_id'
                                             ]);
                    foreach ($modifiers as $modifier) {
                        $modifier->update([
                            'player_id' => $player->id
                        ]);

                        // override any corruptions or factions
                        if ($modifier->is_corrupt) {
                            $player->overridden_corrupt = 1;
                        }
                        if ($modifier->faction_id) {
                            $player->overridden_faction_id = $modifier->faction_id;
                        }
                    }

                    // add any position notes to the player record
                    if ($position->notes_from_mod) {
                        $player->notes_from_mod = $position->notes_from_mod;
                    }

                }

                // allocate the role to the player, save player record
                $player->allocated_role_id = $position->role_id;
                $player->listing_order = $updatedOrders[$player->id];
                $player->save();

                // update the position to allocated
                $position->allocated = 1;
                $position->save();
            }
        }

        // announce to players that the game is updated
        GameUpdated::dispatch('ready', null, $game->id);

        // show a listing of all the players and their allocated role to the mod to finish up.
        $data['players'] = Player::where('game_id', $game->id)
                                 ->orderBy('listing_order')->get();

        $data['modifiers'] = GameModifier::where('game_id', $game->id)
                                 ->join('modifiers', 'game_modifiers.modifier_id', '=', 'modifiers.id')
                                 ->get([
                                     'player_id',
                                     'name'
                                 ]);

        $data['roles'] = Role::with('faction')->get();
        $data['game'] = $game;
        return view('mod.player_list', ['data' => $data]);
    }

    public function addNoPhone(Request $request, Game $game)
    {
        if (!$request->name) {
            return back();
        }

        $nextOrder = Player::where('game_id', $game->id)->max('listing_order');
        if(!$nextOrder) {
            $nextOrder = 0;
        }

        Player::create([
            'name' => $request->name,
            'game_id' => $game->id,
            'listing_order' => $nextOrder++
        ]);

        return redirect('/game/'.$game->id);

    }
}

<?php

use App\Role;
use App\Faction;
use Illuminate\Database\Seeder;

class FactionRoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $factions[] = ['name' => 'Wolf Pack', 'moons' => 1, 'f_order' => 1];
        $factions[] = ['name' => 'Defector', 'moons' => 1, 'f_order' => 2];
        $factions[] = ['name' => 'Village', 'moons' => 1, 'f_order' => 3];
        $factions[] = ['name' => 'Jester', 'moons' => 1, 'f_order' => 4];
        $factions[] = ['name' => 'Madman', 'moons' => 1, 'f_order' => 5];
        $factions[] = ['name' => 'Vampire', 'moons' => 2, 'f_order' => 6];
        $factions[] = ['name' => 'Igor', 'moons' => 2, 'f_order' => 6];
        $factions[] = ['name' => 'Criminals', 'moons' => 2, 'f_order' => 7];
        $factions[] = ['name' => 'City', 'moons' => 2, 'f_order' => 8];
        $factions[] = ['name' => 'Lovers', 'moons' => 2, 'f_order' => 9];

        foreach($factions as $faction) {
            Faction::create($faction);
        }

        $factions = Faction::get();

        $roles[] = ['name' => 'Alpha Wolf', 'faction' => "Wolf Pack", 'announced_faction' => null, 'r_order' => 1];
        $roles[] = ['name' => 'Pack Wolf', 'faction' => "Wolf Pack", 'announced_faction' => null, 'r_order' => 2];
        $roles[] = ['name' => 'Wolf Pup', 'faction' => "Wolf Pack", 'announced_faction' => null, 'r_order' => 3];
        $roles[] = ['name' => 'Defector', 'faction' => "Defector", 'announced_faction' => null, 'r_order' => 4];
        $roles[] = ['name' => 'Clairvoyant', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 5];
        $roles[] = ['name' => 'Wizard', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 6];
        $roles[] = ['name' => 'Medium', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 7];
        $roles[] = ['name' => 'Witch', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 8];
        $roles[] = ['name' => 'Healer', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 9];
        $roles[] = ['name' => 'Farmer', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 10];
        $roles[] = ['name' => 'Farmer', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 11];
        $roles[] = ['name' => 'Priest', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 12];
        $roles[] = ['name' => 'Sinner', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 13];
        $roles[] = ['name' => 'Monk', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 14];
        $roles[] = ['name' => 'Bard', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 15];
        $roles[] = ['name' => 'Innkeeper', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 16];
        $roles[] = ['name' => 'Hermit', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 17];
        $roles[] = ['name' => 'Jester', 'faction' => "Jester", 'announced_faction' => null, 'r_order' => 18];
        $roles[] = ['name' => 'Madman', 'faction' => "Madman", 'announced_faction' => null, 'r_order' => 19];
        $roles[] = ['name' => 'Farmer', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 20];

        foreach($roles as $role) {
            $role['faction_id'] = $factions->where('name', $role['faction'])->first()->id;
            $role['description'] = "Description TBC";
            if (!is_null($role['announced_faction'])) {
                $role['notification_faction_id'] = $factions->where('name', $role['announced_faction'])->first()->id;
            }
            unset($role['faction']);
            unset($role['announced_faction']);

            Role::create($role);
        }


    }
}

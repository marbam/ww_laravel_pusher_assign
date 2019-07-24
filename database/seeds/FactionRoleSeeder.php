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
        $factions[] = ['name' => 'Inquisition', 'moons' => 3, 'f_order' => 10];
        $factions[] = ['name' => 'Vagrant', 'moons' => 3, 'f_order' => 11];
        $factions[] = ['name' => 'Hag', 'moons' => 3, 'f_order' => 12];
        $factions[] = ['name' => 'Lone Wolf', 'moons' => 3, 'f_order' => 14];
        $factions[] = ['name' => 'Necromancer', 'moons' => 3, 'f_order' => 15];
        $factions[] = ['name' => 'Nosferatu', 'moons' => 3, 'f_order' => 16];
        $factions[] = ['name' => 'Possessed', 'moons' => 3, 'f_order' => 17];
        $factions[] = ['name' => 'Pestilent', 'moons' => 3, 'f_order' => 17];
        $factions[] = ['name' => 'Poacher', 'moons' => 3, 'f_order' => 18];
        $factions[] = ['name' => 'Wolf Pack_', 'moons' => 3, 'f_order' => 19];

        // announcing only
        $factions[] = ['name' => 'Juliet', 'moons' => 2, 'f_order' => 50, 'show_in_listing' => false];
        $factions[] = ['name' => 'Guardian Angel', 'moons' => 2, 'f_order' => 50, 'show_in_listing' => false];
        $factions[] = ['name' => 'Outcast Wolf', 'moons' => 3, 'f_order' => 13, 'show_in_listing' => false];

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

        $roles[] = ['name' => 'Vampire', 'faction' => "Vampire", 'announced_faction' => "Vampire", 'r_order' => 21];
        $roles[] = ['name' => 'Igor', 'faction' => "Igor", 'announced_faction' => null, 'r_order' => 22]; // not the village, but not announced
        $roles[] = ['name' => 'Vampire Hunter', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 23];

        $roles[] = ['name' => 'Lawyer', 'faction' => "City", 'announced_faction' => "City", 'r_order' => 24];
        $roles[] = ['name' => 'Mayor', 'faction' => "City", 'announced_faction' => "City", 'r_order' => 25];
        $roles[] = ['name' => 'Merchant', 'faction' => "City", 'announced_faction' => "City", 'r_order' => 26];
        $roles[] = ['name' => 'Preacher', 'faction' => "City", 'announced_faction' => "City", 'r_order' => 27];
        $roles[] = ['name' => 'Seducer', 'faction' => "City", 'announced_faction' => "City", 'r_order' => 28];

        $roles[] = ['name' => 'Assassin', 'faction' => "Criminals", 'announced_faction' => "Criminals", 'r_order' => 29];
        $roles[] = ['name' => 'Corrupt Guard', 'faction' => "Criminals", 'announced_faction' => "Criminals", 'r_order' => 30];
        $roles[] = ['name' => 'Guild Master', 'faction' => "Criminals", 'announced_faction' => "Criminals", 'r_order' => 31];
        $roles[] = ['name' => 'Thief', 'faction' => "Criminals", 'announced_faction' => "Criminals", 'r_order' => 32];
        $roles[] = ['name' => 'Spy', 'faction' => "Criminals", 'announced_faction' => "Criminals", 'r_order' => 33];
        $roles[] = ['name' => 'Guard', 'faction' => "Criminals", 'announced_faction' => "Criminals", 'r_order' => 34];
        $roles[] = ['name' => 'Guard', 'faction' => "Criminals", 'announced_faction' => "Criminals", 'r_order' => 35];

        $roles[] = ['name' => 'Juliet', 'faction' => "Lovers", 'announced_faction' => "Juliet", 'r_order' => 36];
        $roles[] = ['name' => 'Guardian Angel', 'faction' => "Lovers", 'announced_faction' => "Guardian Angel", 'r_order' => 37];

        $roles[] = ['name' => 'Pestilent', 'faction' => "Village", 'announced_faction' => "Pestilent", 'r_order' => 38];
        $roles[] = ['name' => 'Undertaker', 'faction' => "Village", 'announced_faction' => null, 'r_order' => 39];
        $roles[] = ['name' => 'Poacher', 'faction' => "Village", 'announced_faction' => "Poacher", 'r_order' => 39];
        $roles[] = ['name' => 'Vagrant', 'faction' => "Vagrant", 'announced_faction' => "Vagrant", 'r_order' => 39];
        
        $roles[] = ['name' => 'Inquisitor', 'faction' => "Inquisition", 'announced_faction' => "Inquisition", 'r_order' => 39];
        $roles[] = ['name' => 'Executioner', 'faction' => "Inquisition", 'announced_faction' => "Inquisition", 'r_order' => 39];
        $roles[] = ['name' => 'Templar', 'faction' => "Inquisition", 'announced_faction' => "Inquisition", 'r_order' => 39];

        $roles[] = ['name' => 'Hag', 'faction' => "Hag", 'announced_faction' => "Hag", 'r_order' => 40];
        $roles[] = ['name' => 'Outcast Wolf', 'faction' => "Wolf Pack_", 'announced_faction' => "Outcast Wolf", 'r_order' => 41];
        $roles[] = ['name' => 'Lone Wolf', 'faction' => "Lone Wolf", 'announced_faction' => "Lone Wolf", 'r_order' => 42];
        $roles[] = ['name' => 'Necromancer', 'faction' => "Necromancer", 'announced_faction' => "Necromancer", 'r_order' => 43];
        $roles[] = ['name' => 'Nosferatu', 'faction' => "Nosferatu", 'announced_faction' => "Necromancer", 'r_order' => 44];
        $roles[] = ['name' => 'Possessed', 'faction' => "Possessed", 'announced_faction' => "Possessed", 'r_order' => 45];

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

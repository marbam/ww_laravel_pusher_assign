<?php

use Illuminate\Database\Seeder;

class ModifiersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modifiers[] = ['name' => 'Bard', 'description' => "You're still your original role, you just also give Non-corrupt news if you're alive in the morning"];
        $modifiers[] = ['name' => 'Innkeeper', 'description' => "You're still your original role, you just also give Corrupt news if you're alive in the morning"];
        $modifiers[] = ['name' => 'Sinful', 'is_corrupt' => 1, 'description' => "You're still your original role, however you appear as corrupt when checked by a Mystic"];
        $modifiers[] = ['name' => 'Treacherous', 'description' => "You keep your original role, only now you're working with the wolves!"];
        $modifiers[] = ['name' => 'Competitive', 'description' => "You keep your original role, but if you're the first competitive player to die, you lose!", 'can_have_multiple' => 1, 'is_experimental' => 1];


        foreach ($modifiers as $modifier) {
            DB::table('modifiers')->insert($modifier);
        }

    }
}

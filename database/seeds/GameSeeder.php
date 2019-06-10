<?php

use App\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	Game::create([
    		'code' => 'apple',
    		'moderator_id' => 1
    	]);

    	Game::create([
    		'code' => 'bob',
    		'moderator_id' => 1
    	]);


    	Game::create([
    		'code' => 'carrot',
    		'moderator_id' => 2
    	]);

    }
}

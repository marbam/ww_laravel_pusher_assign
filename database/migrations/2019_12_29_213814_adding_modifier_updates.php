<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingModifierUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function($table) {
            $table->boolean('has_modifiers')->nullable();
        });

        Schema::table('players', function($table) {
            $table->boolean('overridden_corrupt')->nullable();
            $table->unsignedBigInteger('overridden_faction_id')->nullable();
            $table->foreign('overridden_faction_id')->references('id')->on('factions');
            $table->text('notes_from_mod')->nullable();
        });

        Schema::create('modifiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->boolean('is_corrupt')->nullable();
            $table->boolean('is_mystic')->nullable();
            $table->unsignedBigInteger('faction_id')->nullable();
            $table->foreign('faction_id')->references('id')->on('factions');
            $table->string('description', 200)->nullable();
            $table->boolean('can_have_multiple')->nullable();
            $table->boolean('is_experimental')->nullable();
            $table->timestamps();
        });

        Schema::create('game_modifiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games');
            $table->unsignedBigInteger('modifier_id')->nullable();
            $table->foreign('modifier_id')->references('id')->on('modifiers');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('positions');
            $table->unsignedBigInteger('player_id')->nullable();
            $table->foreign('player_id')->references('id')->on('players');
            $table->timestamps();
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->text('notes_from_mod')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn('notes_from_mod');
        });

        Schema::table('game_modifiers', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropColumn('game_id');
            $table->dropForeign(['modifier_id']);
            $table->dropColumn('modifier_id');
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
            $table->dropForeign(['player_id']);
            $table->dropColumn('player_id');
        });

        Schema::dropIfExists('modifiers');

        Schema::table('games', function($table) {
            $table->dropColumn('has_modifiers');
        });

        Schema::table('players', function($table) {
            $table->dropColumn('overridden_corrupt');
            $table->dropForeign(['overridden_faction_id']);
            $table->dropColumn('overridden_faction_id');
            $table->dropColumn('notes_from_mod');
        });


    }
}

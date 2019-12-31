<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'game_id',
        'listing_order',
        'notes_from_mod'
    ];

    public function role()
    {
		return $this->hasOne("\App\Role", 'id', 'allocated_role_id');
    }

    public function game()
    {
		return $this->hasOne("\App\Game", 'id', 'game_id');
    }
}

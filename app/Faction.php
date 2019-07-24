<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    protected $fillable = [
        'name',
        'moons',
        'f_order',
        'show_in_listing'
    ];

    public function roles()
    {
    	return $this->hasMany("\App\Role");
    }
}

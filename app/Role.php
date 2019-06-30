<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'faction_id', // actual id
        'notification_faction_id' // faction to be announced when role is added.
    ];
}

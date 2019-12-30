<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'code',
        'moderator_id',
        'has_modifiers'
    ];
}

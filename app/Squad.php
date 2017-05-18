<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    public function tournament()
    {
        return $this->belongsTo('App\Tournament', 't_id');
    }

    public function players()
    {
        return $this->belongsToMany('App\User', 'squad_players', 'squad_id', 'player_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    protected $fillable = ['tournament_id', 'date', 'start_time', 'end_time', 'max_players'];

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }

    public function players()
    {
        return $this->belongsToMany('App\User', 'squad_players', 'squad_id', 'player_id');
    }
}

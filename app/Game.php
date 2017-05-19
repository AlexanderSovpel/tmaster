<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['player_id', 'tournament_id', 'part', 'squad_id', 'result', 'bonus', 'date'];

    public function player()
    {
        return $this->belongsTo('App\User', 'player_id');
    }

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }
}

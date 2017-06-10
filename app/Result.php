<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['tournament_id', 'player_id', 'part', 'sum', 'avg', 'squad_id'];

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }

    public function player()
    {
        return $this->belongsTo('App\User', 'player_id');
    }
}

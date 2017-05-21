<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoundRobin extends Model
{
    protected $fillable = ['tournament_id', 'players', 'win_bonus', 'draw_bonus', 'date', 'start_time', 'end_time'];

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }
}

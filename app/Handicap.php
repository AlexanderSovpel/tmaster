<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handicap extends Model
{
    protected $fillable = ['tournament_id', 'type', 'value', 'max_game'];

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }
}

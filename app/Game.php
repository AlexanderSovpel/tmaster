<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['p_id', 't_id', 'stage', 's_id', 'result', 'date'];

    public function player()
    {
        return $this->belongsTo('App\User', 'p_id');
    }

    public function tournament()
    {
        return $this->belongsTo('App\Tournament', 't_id');
    }
}

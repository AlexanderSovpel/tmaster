<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    public function squads()
    {
        return $this->hasMany('App\Squad', 't_id');
    }

    public function games()
    {
        return $this->hasMany('App\Games', 't_id');
    }
}

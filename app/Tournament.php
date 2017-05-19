<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    public function squads()
    {
        return $this->hasMany('App\Squad');
    }

    public function games()
    {
        return $this->hasMany('App\Games');
    }

    public function results()
    {
        return $this->hasMany('App\Result');
    }
}

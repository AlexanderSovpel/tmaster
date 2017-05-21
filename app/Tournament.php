<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = ['name', 'location', 'type', 'oil_type', 'description',
        'handicap_id',
        'has_desperado', 'has_roundrobin', 'has_stepladder', 'has_commonfinal', 'has_joinmatches',
        'qualification_id',
        'roundrobin_id',
        'contact_id',
        'finished'];

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

    public function handicap()
    {
        return $this->hasOne('App\Handicap');
    }

    public function qualification()
    {
        return $this->hasOne('App\Qualification');
    }

    public function roundRobin()
    {
        return $this->hasOne('App\RoundRobin');
    }

    public function contact()
    {
        return $this->hasOne('App\User', 'id', 'contact_id');
    }
}

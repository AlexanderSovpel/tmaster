<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'birthday', 'gender', 'phone', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'is_admin', 'remember_token',
    ];

    public function squads()
    {
        return $this->belongsToMany('App\Squad', 'squad_players', 'squad_id', 'player_id');
    }

    public function games()
    {
        return $this->hasMany('App\Game', 'player_id');
    }

    public function results()
    {
        return $this->hasMany('App\Result', 'player_id');
    }
//    public function tournament() {
//        return $this->belongsTo('App\Tournament', 'contact_id');
//    }
}

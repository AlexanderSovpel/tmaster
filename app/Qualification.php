<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = ['entries', 'games', 'finalists', 'fee', 'allow_reentry', 'reentries', 'reentry_fee'];

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Result;

class FixFinalResult extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Result::where('tournament_id', 42)->where('player_id', 122)->where('part', 'rr')->update(['sum' => 2058]);
    }
}

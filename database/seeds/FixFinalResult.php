<?php

use Illuminate\Database\Seeder;

class FixFinalResult extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::('results')->where('tournament_id', 42)->where('player_id', 122)
                       ->where('part', 'rr')->update(['sum' => 2058]);
    }
}

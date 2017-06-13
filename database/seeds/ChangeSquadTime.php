<?php

use Illuminate\Database\Seeder;

class ChangeSquadTime extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('squads')
            ->where('id', 62)
            ->update(['start_time' => '12:30',
                      'end_time' => '14:30']);
    }
}

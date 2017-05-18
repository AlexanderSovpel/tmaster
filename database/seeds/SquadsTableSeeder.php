<?php

use Illuminate\Database\Seeder;

class SquadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('squads')->insert([
            'date' => '2017-05-13',
            'start_time' => '10:00',
            'end_time' => '13:00',
            'max_players' => 8,
            't_id' => 1
        ]);

        DB::table('squads')->insert([
            'date' => '2017-05-13',
            'start_time' => '14:00',
            'end_time' => '16:00',
            'max_players' => 8,
            't_id' => 1
        ]);
    }
}

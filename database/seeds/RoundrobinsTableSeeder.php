<?php

use Illuminate\Database\Seeder;

class RoundrobinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('round_robins')->insert([
            'tournament_id' => 1,
            'players' => 4,
            'win_bonus' => 20,
            'draw_bonus' => 10,
            'date' => '2017-05-14',
            'start_time' => '12:00',
            'end_time' => '14:00'
        ]);
    }
}

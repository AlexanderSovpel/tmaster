<?php

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 123,
            'bonus' => 0,
            'date' => '2017-01-10'
        ]);

        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 150,
            'bonus' => 0,
            'date' => '2017-01-10'
        ]);

        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 200,
            'bonus' => 0,
            'date' => '2017-01-10'
        ]);

        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 138,
            'bonus' => 0,
            'date' => '2017-02-10'
        ]);

        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 156,
            'bonus' => 0,
            'date' => '2017-02-10'
        ]);

        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 247,
            'bonus' => 0,
            'date' => '2017-02-10'
        ]);

        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 119,
            'bonus' => 0,
            'date' => '2017-03-10'
        ]);

        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 175,
            'bonus' => 0,
            'date' => '2017-03-10'
        ]);

        DB::table('games')->insert([
            'player_id' => 11,
            'tournament_id' => 9,
            'part' => 'q',
            'squad_id' => 9,
            'result' => 217,
            'bonus' => 0,
            'date' => '2017-03-10'
        ]);
    }
}

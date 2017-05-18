<?php

use Illuminate\Database\Seeder;

class SquadPlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('squad_players')->insert([
            'squad_id' => 1,
            'player_id' => 1
        ]);

        DB::table('squad_players')->insert([
            'squad_id' => 1,
            'player_id' => 2
        ]);

        DB::table('squad_players')->insert([
            'squad_id' => 1,
            'player_id' => 3
        ]);

        DB::table('squad_players')->insert([
            'squad_id' => 2,
            'player_id' => 4
        ]);

        DB::table('squad_players')->insert([
            'squad_id' => 2,
            'player_id' => 5
        ]);

        DB::table('squad_players')->insert([
            'squad_id' => 2,
            'player_id' => 6
        ]);
    }
}

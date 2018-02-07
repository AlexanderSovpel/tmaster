<?php

use Illuminate\Database\Seeder;
use App\SquadPlayers;

class ApplyForTournament extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SquadPlayers::where('squad_id', 82)->delete();
        SquadPlayers::create(['squad_id' => 82, 'player_id' => 192]);
        SquadPlayers::create(['squad_id' => 82, 'player_id' => 172]);
        SquadPlayers::create(['squad_id' => 82, 'player_id' => 132]);
        SquadPlayers::create(['squad_id' => 82, 'player_id' => 122]);
        SquadPlayers::create(['squad_id' => 82, 'player_id' => 72]);
        SquadPlayers::create(['squad_id' => 82, 'player_id' => 82]);

        SquadPlayers::where('squad_id', 92)->delete();
        SquadPlayers::create(['squad_id' => 92, 'player_id' => 152]);
        SquadPlayers::create(['squad_id' => 92, 'player_id' => 172]);
        SquadPlayers::create(['squad_id' => 92, 'player_id' => 122]);
        SquadPlayers::create(['squad_id' => 92, 'player_id' => 132]);
        SquadPlayers::create(['squad_id' => 92, 'player_id' => 222]);
        SquadPlayers::create(['squad_id' => 92, 'player_id' => 162]);
        SquadPlayers::create(['squad_id' => 92, 'player_id' => 142]);
        SquadPlayers::create(['squad_id' => 92, 'player_id' => 112]);
    }
}

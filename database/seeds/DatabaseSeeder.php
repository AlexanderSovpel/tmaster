<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(TournamentsTableSeeder::class);
        $this->call(SquadsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SquadPlayersTableSeeder::class);
    }
}

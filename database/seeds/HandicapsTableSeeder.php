<?php

use Illuminate\Database\Seeder;

class HandicapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('handicaps')->insert([
            'type' => 'женский',
            'value' => 8,
            'max_game' => 300
        ]);
    }
}

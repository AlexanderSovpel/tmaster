<?php

use Illuminate\Database\Seeder;

class TournamentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournament')->insert([
            'name' => 'V этап чемпионата РБ',
            'location' => 'Bowling House',
            'type' => 'sport',
            'oil_type' => 'middle',
            'oil_file' => null,
            'description' => '',
            'handicap_id' => 1,
            'qualification_id' => 1,
            'roundrobin_id' => 1,
            'contact_id' => 7,
            'finished' => false
        ]);
    }
}

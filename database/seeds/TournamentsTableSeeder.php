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

//            'handicap_type' => 'women',

//            'qualification_fee' => 50.0,
//            'reentry_fee' => 60.0,

//            'rr_date' => '2017-05-14',
//            'rr_start_time' => '12:00',
//            'rr_end_time' => '14:00',

//            'contact_person' => 'Sovpel Alex',
//            'contact_phone' => '+375296425962',
//            'contact_email' => 'Sovpel Alex',

            'finished' => false
        ]);
    }
}

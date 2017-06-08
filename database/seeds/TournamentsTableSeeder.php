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
        $handicap_id = DB::table('handicaps')->insertGetId([
            'type' => 'женский',
            'value' => 8,
            'max_game' => 300
        ]);

        $qualification_id = DB::table('qualifications')->insertGetId([
            'tournament_id' => 1,
            'entries' => 6,
            'games' => 1,
            'finalists' => 4,
            'fee' => 50.0,
            'allow_reentry' => true,
            'reentries' => 1,
            'reentry_fee' => 60.0
        ]);

        $roundrobin_id = DB::table('round_robins')->insertGetId([
            'tournament_id' => 1,
            'players' => 4,
            'win_bonus' => 20,
            'draw_bonus' => 10,
            'date' => '2017-05-14',
            'start_time' => '12:00',
            'end_time' => '14:00'
        ]);

        $contact = DB::table('users')->where('is_admin', true)->first();

        DB::table('tournament')->insert([
            'name' => 'V этап чемпионата РБ',
            'location' => 'Bowling House',
            'type' => 'sport',
            'oil_type' => 'middle',
            'description' => '',
            'handicap_id' => $handicap_id,
            'qualification_id' => $qualification_id,
            'roundrobin_id' => $roundrobin_id,
            'contact_id' => $contact->id,
            'finished' => false
        ]);
    }
}

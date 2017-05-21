<?php

use Illuminate\Database\Seeder;

class QualificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('qualifications')->insert([
            'tournament_id' => 1,
            'entries' => 6,
            'games' => 1,
            'finalists' => 4,
            'fee' => 50.0,
            'allow_reentry' => true,
            'reentries' => 1,
            'reentry_fee' => 60.0
        ]);
    }
}

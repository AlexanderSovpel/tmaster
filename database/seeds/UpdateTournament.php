<?php

use Illuminate\Database\Seeder;

class UpdateTournament extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournaments')->where('id', 42)
          ->update(['name' => 'VII этап чемпионата РБ сезона 2016-2017']);
    }
}

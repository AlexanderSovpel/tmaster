<?php

use Illuminate\Database\Seeder;

class RemoveDumpUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->where('id', '<', 60)->delete();
    }
}

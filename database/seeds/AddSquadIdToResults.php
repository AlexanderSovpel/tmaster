<?php

use Illuminate\Database\Seeder;
use App\Result;

class AddSquadIdToResults extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $results = Result::where('tournament_id', 42)->get();
        for ($i = 0; $i < count($results); ++$i) {
          if ($i < 6)
            $results[$i]->update(['squad_id' => 82]);
          else
          $results[$i]->update(['squad_id' => 92]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\User;

class AvatarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
          $user->avatar = "avatar_".$user->id.".jpg";
        }
    }
}

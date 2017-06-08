<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSquadPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('squad_players')) {
            Schema::create('squad_players', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('squad_id');
                $table->integer('player_id');
                $table->timestamps();

                // $table->foreign('squad_id')->references('id')->on('squads');
                // $table->foreign('player_id')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

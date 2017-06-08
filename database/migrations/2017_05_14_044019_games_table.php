<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('games')) {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id');
            $table->integer('tournament_id');
            $table->integer('squad_id');
            $table->string('part');
            $table->integer('result');
            $table->integer('bonus');
            $table->date('date');
            $table->timestamps();
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
        Schema::dropIfExists('games');
    }
}

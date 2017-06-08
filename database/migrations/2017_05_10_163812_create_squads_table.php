<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSquadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('squads')) {
        Schema::create('squads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tournament_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_players');
            $table->boolean('finished');
            $table->timestamps();

            // $table->foreign('tournament_id')->references('id')->on('tournaments');
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
        Schema::dropIfExists('squads');
    }
}

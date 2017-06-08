<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('results')) {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tournament_id');
            $table->integer('player_id');
            $table->string('part');
            $table->integer('sum');
            $table->double('avg');
            $table->timestamps();

            // $table->foreign('tournament_id')->references('id')->on('tournaments');
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
        Schema::dropIfExists('results');
    }
}

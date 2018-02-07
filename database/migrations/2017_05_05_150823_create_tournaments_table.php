<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('tournaments')) {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('location');
            $table->string('type');
            $table->string('oil_type');
            $table->longText('description');
            $table->integer('handicap_id')->unsigned();
            $table->integer('qualification_id')->unsigned();
            $table->integer('roundrobin_id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->boolean('finished');
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
        Schema::dropIfExists('tournament');
    }
}

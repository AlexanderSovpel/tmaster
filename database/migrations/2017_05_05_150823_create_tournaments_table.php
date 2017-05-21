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
        Schema::create('tournament', function (Blueprint $table) {
//            common
            $table->increments('id');
            $table->string('name');
            $table->string('location');
            $table->string('type');
            $table->string('oil_type');
            $table->binary('oil_file')->nullable();
            $table->longText('description');

//            handicap
//            $table->string('handicap_type')->default('women')->nullable();
//            $table->integer('handicap_value')->default(8);
//            $table->integer('handicap_max_game')->default(300);
//            $table->string('handicap_id')->references('id')->on('handicaps');

//            stages
            $table->boolean('has_desperado')->default(false);
            $table->boolean('has_roundrobin')->default(true);
            $table->boolean('has_stepladder')->default(false);
            $table->boolean('has_commonfinal')->default(false);
            $table->boolean('has_joinmatches')->default(false);

////             qualification stage
//            $table->integer('qualification_entries')->default(6);
//            $table->integer('qualification_games')->default(1);
//            $table->integer('qualification_finalists')->default(6);
//
////            payment
//            $table->double('qualification_fee');
//            $table->boolean('allow_reentry')->default(true);
//            $table->integer('reentries_amount')->default(1);
//            $table->double('reentry_fee');

//            round robin
//            $table->integer('rr_players')->default(6);
//            $table->integer('rr_win_bonus')->default(20);
//            $table->integer('rr_draw_bonus')->default(10);
//            $table->date('rr_date');
//            $table->time('rr_start_time');
//            $table->time('rr_end_time');

//            contacts
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->string('contact_email');

            $table->boolean('finished');

            $table->timestamps();
        });
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

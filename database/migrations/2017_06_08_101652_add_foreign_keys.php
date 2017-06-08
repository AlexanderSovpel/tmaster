<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (Schema::hasTable('tournaments')) {
        Schema::table('tournaments', function (Blueprint $table) {
          $table->foreign('handicap_id')->references('id')->on('handicaps')->onDelete('cascade');
          $table->foreign('qualification_id')->references('id')->on('qualifications')->onDelete('cascade');
          $table->foreign('roundrobin_id')->references('id')->on('roundrobins')->onDelete('cascade');
          $table->foreign('contact_id')->references('id')->on('users');
        });
      }

      if (Schema::hasTable('squads')) {
        Schema::table('squads', function (Blueprint $table) {
          $table->foreign('tournament_id')->references('id')->on('tournaments');
        });
      }

      if (Schema::hasTable('squad_players')) {
        Schema::table('squad_players', function (Blueprint $table) {
          $table->foreign('squad_id')->references('id')->on('squads');
          $table->foreign('player_id')->references('id')->on('users');
        });
      }

      if (Schema::hasTable('games')) {
        Schema::table('games', function (Blueprint $table) {
          $table->foreign('player_id')->references('id')->on('users');
          $table->foreign('tournament_id')->references('id')->on('tournaments');
        });
      }

      if (Schema::hasTable('results')) {
        Schema::table('results', function (Blueprint $table) {
          $table->foreign('tournament_id')->references('id')->on('tournaments');
          $table->foreign('player_id')->references('id')->on('users');
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
      if (Schema::hasTable('tournaments')) {
        Schema::table('tournaments', function (Blueprint $table) {
          $table->dropForeign('tournaments_handicap_id_foreign');
          $table->dropForeign('tournaments_qualification_id_foreign');
          $table->dropForeign('tournaments_roundrobin_id_foreign');
          $table->dropForeign('tournaments_contact_id_foreign');
        });
      }

      if (Schema::hasTable('squads')) {
        Schema::table('squads', function (Blueprint $table) {
          $table->dropForeign('squads_tournament_id_foreign');
        });
      }

      if (Schema::hasTable('squad_players')) {
        Schema::table('squad_players', function (Blueprint $table) {
          $table->dropForeign('squad_players_squad_id_foreign');
          $table->dropForeign('squad_players_player_id_foreign');
        });
      }

      if (Schema::hasTable('games')) {
        Schema::table('games', function (Blueprint $table) {
          $table->dropForeign('games_player_id_foreign');
          $table->dropForeign('games_tournament_id_foreign');
        });
      }

      if (Schema::hasTable('results')) {
        Schema::table('results', function (Blueprint $table) {
          $table->dropForeign('results_tournament_id_foreign');
          $table->dropForeign('results_player_id_id_foreign');
        });
      }
    }
}

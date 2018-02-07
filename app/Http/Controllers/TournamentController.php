<?php

namespace App\Http\Controllers;

use App\Game;
use App\Handicap;
use App\Qualification;
use App\Result;
use App\RoundRobin;
use App\Squad;
use App\SquadPlayers;
use App\Tournament;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;

class TournamentController extends Controller {
    // private $tournaments;

    public function __construct() {
        // $this->middleware('auth');
    }

    public function index() {
        $tournaments = Tournament::join('squads', 'squads.tournament_id', '=', 'tournaments.id')
          ->orderBy('squads.date', 'DESC')
          ->select('tournaments.*')
          ->distinct()
          ->paginate(4);
        $user = Auth::user();

        return view('index', ['tournaments' => $tournaments, 'user' => $user]);
    }

    public function details($tournamentId) {
        $tournament = Tournament::find($tournamentId);
        return view('tournament.tournament-details', [
            'tournament' => $tournament,
            'user' => Auth::user()
        ]);
    }

    public function players($id) {
        $tournament = Tournament::find($id);

        return view('tournament.players', ['tournament' => $tournament]);
    }

    public function results($tournamentId) {
        $tournament = Tournament::find($tournamentId);

        $sPlayers = array();
        $sGames = array();
        $sResults = array();
        foreach($tournament->squads as $squad) {
          list($sPlayers[$squad->id], $sGames[$squad->id], $sResults[$squad->id]) = TournamentController::getSquadResults($tournament, $squad);
        }

        $qPlayers = array();
        $qGames = array();
        $qResults = array();
        list($qPlayers, $qGames, $qResults) = TournamentController::getQualificationResults($tournament);

        $fGames = array();
        $fResults = array();
        $fPlayers = array();
        $roundCount = 0;
        if (isset($tournament->roundRobin)) {
          list($fPlayers, $fGames, $fResults) = TournamentController::getRoundRobinResults($tournament);
          $fPlayersCount = count($fPlayers);
          $roundCount = ($fPlayersCount % 2) ? $fPlayersCount : $fPlayersCount - 1;
        }

        $allResults = $fResults;
        foreach ($qResults as $key => $result) {
            if ($result && !isset($fResults[$result->player_id])) {
                $allResults[] = $result;
            }
        }

        usort($allResults, function ($resultA, $resultB) {
            return ($resultA->sum < $resultB->sum);
        });

        return view('tournament.results', [
            'tournament' => $tournament,
            'sPlayers' => $sPlayers,
            'sGames' => $sGames,
            'sResults' => $sResults,
            'qPlayers' => $qPlayers,
            'qGames' => $qGames,
            'qResults' => $qResults,
            'fPlayers' => $fPlayers,
            'fGames' => $fGames,
            'fResults' => $fResults,
            'roundCount' => $roundCount,
            'allResults' => $allResults
        ]);
    }

    public static function sortPlayersByResult(&$players, $tournamentId, $part, $squadId) {
        usort($players, function ($playerA, $playerB) use ($tournamentId, $part, $squadId) {
            $playerAResult = $playerA['results']
                ->where('tournament_id', $tournamentId)
                ->where('part', $part);
            $playerBResult = $playerB['results']
                ->where('tournament_id', $tournamentId)
                ->where('part', $part);
            if ($squadId) {
              $playerAResult = $playerAResult->where('squad_id', $squadId);
              $playerBResult = $playerBResult->where('squad_id', $squadId);
            }
            $playerAResult = $playerAResult->max('sum');
            $playerBResult = $playerBResult->max('sum');
            return ($playerAResult < $playerBResult);
        });
    }

    public static function getSquadResults($tournament, $squad) {
      $sPlayers = array();
      $sGames = array();
      $sResults = array();

      foreach ($squad->players as $player) {
        $squadPlayer = SquadPlayers::where('player_id', $player->id)
            ->where('squad_id', $squad->id)
            ->first();

        if ($squadPlayer->present) {
          $sPlayers[] = $player;

          $squadGames = Game::where('tournament_id', $tournament->id)
              ->where('player_id', $player->id)
              ->where('part', 'q')
              ->where('squad_id', $squad->id)
              ->get();
          $sGames[$player->id] = $squadGames;

          $squadResult = $qResult = Result::where('tournament_id', $tournament->id)
              ->where('player_id', $player->id)
              ->where('part', 'q')
              ->where('squad_id', $squad->id)
              ->first();
          $sResults[$player->id] = $squadResult;
        }
      }

      TournamentController::sortPlayersByResult($sPlayers, $tournament->id, 'q', $squad->id);

      return array($sPlayers, $sGames, $sResults);
    }

    public static function getQualificationResults($tournament) {
      $qPlayers = array();
      $qGames = array();
      $qResults = array();

      $qPlayersId = array();
      foreach ($tournament->squads as $squad) {
        foreach ($squad->players as $player) {
          $squadPlayer = SquadPlayers::where('player_id', $player->id)
              ->where('squad_id', $squad->id)
              ->first();

          if ($squadPlayer->present) {
            $qPlayersId[] = $player->id;
          }
        }
      }

      $qPlayersId = array_unique($qPlayersId);
      foreach($qPlayersId as $playerId) {
        $player = User::find($playerId);
        $qPlayers[] = $player;
      }

      foreach($qPlayers as $player) {
        $bestSquadResultSum = Result::where('tournament_id', $tournament->id)
            ->where('player_id', $player->id)
            ->where('part', 'q')
            ->max('sum');
        if($bestSquadResultSum) {
          $bestSquadResult = Result::where('tournament_id', $tournament->id)
              ->where('player_id', $player->id)
              ->where('part', 'q')
              ->where('sum', $bestSquadResultSum)
              ->first();
          $qResults[$player->id] = $bestSquadResult;

          $bestSquadId = $bestSquadResult->squad_id;
          $bestSquadGames = Game::where('tournament_id', $tournament->id)
              ->where('player_id', $player->id)
              ->where('part', 'q')
              ->where('squad_id', $bestSquadId)
              ->get();
          $qGames[$player->id] = $bestSquadGames;
        }
      }

      TournamentController::sortPlayersByResult($qPlayers, $tournament->id, 'q', null);

      return array($qPlayers, $qGames, $qResults);
    }

    public static function getRoundRobinResults($tournament) {
      $rrPlayers = array();
      $rrGames = array();
      $rrResults = array();

      $roundRobinResults = Result::where('tournament_id', $tournament->id)
          ->where('part', 'rr')
          ->get();
      foreach ($roundRobinResults as $result) {
        $playerId = $result->player_id;

        $roundRobinPlayer = User::find($playerId);
        $rrPlayers[] = $roundRobinPlayer;

        $roundRobinGames = Game::where('tournament_id', $tournament->id)
            ->where('player_id', $playerId)
            ->where('part', 'rr')
            ->get();
        $rrGames[$playerId] = $roundRobinGames;

        $rrResults[$playerId] = $result;

      }

      TournamentController::sortPlayersByResult($rrPlayers, $tournament->id, 'rr', null);

      return array($rrPlayers, $rrGames, $rrResults);
    }

    public function newTournament() {
        $admins = User::where('is_admin', 1)->get();
        return view('tournament.new-tournament', ['admins' => $admins]);
    }

    public function createTournament(Request $request) {
        $handicap = new Handicap([
            'type' => $request->handicap_type,
            'value' => $request->handicap_value,
            'max_game' => $request->handicap_max_game
        ]);
        $handicap->save();

        $qualification = new Qualification([
            'entries' => $request->qualification_entries,
            'games' => $request->qualification_games,
            'finalists' => $request->qualification_finalists,
            'fee' => $request->qualification_fee,
            'allow_reentry' => (boolean)$request->allow_reentry,
            'reentries' => $request->reentries_amount,
            'reentry_fee' => $request->reentry_fee
        ]);
        $qualification->save();

        if ($request->has_roundrobin) {
          $roundRobin = new RoundRobin([
              'players' => $request->rr_players,
              'win_bonus' => $request->rr_win_bonus,
              'draw_bonus' => $request->rr_draw_bonus,
              'date' => $request->rr_date,
              'start_time' => $request->rr_start_time,
              'end_time' => $request->rr_end_time,
          ]);
          $roundRobin->save();
        }


        $contact = User::find($request->contact_person);

        $newTournament = new Tournament([
            'name' => $request->name,
            'location' => $request->location,
            'type' => $request->type,
            'oil_type' => $request->oil_type,
            'description' => $request->description,
            'handicap_id' => $handicap->id,
            'qualification_id' => $qualification->id,
            'contact_id' => $contact->id,
            'finished' => false
        ]);
        $newTournament->save();

        $handicap->tournament_id = $newTournament->id;
        $handicap->save();

        $qualification->tournament_id = $newTournament->id;
        $qualification->save();

        if ($request->has_roundrobin) {
          $newTournament->roundrobin_id = $roundRobin->id;
          $newTournament->save();

          $roundRobin->tournament_id = $newTournament->id;
          $roundRobin->save();
        }

        for ($i = 0; $i < $request->squads_count; ++$i) {
            $squad = new Squad([
                'tournament_id' => $newTournament->id,
                'date' => $request->squad_date[$i],
                'start_time' => $request->squad_start_time[$i],
                'end_time' => $request->squad_end_time[$i],
                'max_players' => $request->squad_max_players[$i],
                'finished' => false
            ]);
            $squad->save();
        }

        return $newTournament;
    }

    public function deleteTournament($tournamentId) {
      $tournament = Tournament::find($tournamentId);
      $tournament->delete();
      return redirect('/');
    }

    public function editTournament($tournamentId) {
        $tournament = Tournament::find($tournamentId);
        $admins = User::where('is_admin', 1)->get();
        return view('tournament.tournament-edit', ['tournament' => $tournament, 'admins' => $admins]);
    }

    public function saveTournament(Request $request, $tournamentId) {
        $tournament = Tournament::find($tournamentId);

        $tournament->name = $request->name;
        $tournament->location = $request->location;
        $tournament->type = $request->type;
        $tournament->oil_type = $request->oil_type;
        $tournament->description = $request->description;

        $tournament->handicap->type = $request->handicap_type;
        $tournament->handicap->value = $request->handicap_value;
        $tournament->handicap->max_game = $request->handicap_max_game;
        $tournament->handicap->save();

        $tournament->qualification->entries = $request->qualification_entries;
        $tournament->qualification->games = $request->qualification_games;
        $tournament->qualification->finalists = $request->qualification_finalists;
        $tournament->qualification->fee = $request->qualification_fee;
        $tournament->qualification->allow_reentry = (boolean)$request->allow_reentry;
        $tournament->qualification->reentries = $request->reentries_amount;
        $tournament->qualification->reentry_fee = $request->reentry_fee;
        $tournament->qualification->save();

        if ($request->has_roundrobin) {
        if (isset($tournament->roundRobin)) {
            $tournament->roundRobin->players = $request->rr_players;
            $tournament->roundRobin->win_bonus = $request->rr_win_bonus;
            $tournament->roundRobin->draw_bonus = $request->rr_draw_bonus;
            $tournament->roundRobin->date = $request->rr_date;
            $tournament->roundRobin->start_time = $request->rr_start_time;
            $tournament->roundRobin->end_time = $request->rr_end_time;
            $tournament->roundRobin->save();
        }
        else {
            $roundRobin = new RoundRobin(['players' => $request->rr_players,
            'win_bonus' => $request->rr_win_bonus,
            'draw_bonus' => $request->rr_draw_bonus,
            'date' => $request->rr_date,
            'start_time' => $request->rr_start_time,
            'end_time' => $request->rr_end_time]);
            $roundRobin->tournament_id = $tournament->id;
            $roundRobin->save();
            $tournament->roundrobin_id = $roundRobin->id;
        }
        }
        else {
        if (isset($tournament->roundRobin)) {
            $tournament->roundRobin->delete();
        }
        }

        $contact = User::find($request->contact_person);
        $tournament->contact_id = $contact->id;

        foreach ($tournament->squads as $key => $squad) {
        if (!in_array($squad->id, $request->squad_id)) {
            $squad->delete();
        }
        }

        for ($i = 0; $i < $request->squads_count; ++$i) {
        $squad = $tournament->squads()->find($request->squad_id[$i]);
        if ($squad == null) {
            $squad = new Squad();
            $squad->tournament_id = $tournament->id;
            $squad->finished = false;
        }
        $squad->date = $request->squad_date[$i];
        $squad->start_time = $request->squad_start_time[$i];
        $squad->end_time = $request->squad_end_time[$i];
        $squad->max_players = $request->squad_max_players[$i];
        $squad->save();
        }

        $tournament->save();
        return redirect('/');
    }
}

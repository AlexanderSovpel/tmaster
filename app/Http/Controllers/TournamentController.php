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

class TournamentController extends Controller
{
    private $tournaments;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tournaments = Tournament::all()->sortByDesc('id');
        $tournaments = Tournament::join('squads', 'squads.tournament_id', '=', 'tournaments.id')
          ->orderBy('squads.date', 'DESC')
          ->select('tournaments.*')
          ->distinct()
          ->paginate(4);
        $user = Auth::user();

        return view('index', ['tournaments' => $tournaments, 'user' => $user]);
    }

    public function details($tournamentId)
    {
        $tournament = Tournament::find($tournamentId);
        return view('tournament.tournament-details', [
            'tournament' => $tournament,
            'user' => Auth::user()
        ]);
    }

    public function getTournamentPlayers($id)
    {
        $tournament = Tournament::find($id);

        return view('tournament.players', ['tournament' => $tournament]);
    }

    public function getApplication($id)
    {
        $tournament = Tournament::find($id);

        return view('tournament.apply', ['tournament' => $tournament]);
    }

    public function postApplication(Request $request, $id)
    {
        $tournament = Tournament::find($id);
        $playerId = Auth::id();
        if ($request->has('player_id')) {
          $playerId = $request->player_id;
        }
        $squadId = $request->input('squad');

        $playerEntries = 0;
        foreach ($tournament->squads as $squad) {
            if ($squad->players()->find($playerId)) {
                ++$playerEntries;
            }
        }

        if (!$tournament->qualification->allow_reentry) {
            foreach ($tournament->squads as $squad) {
                if ($squad->players()->find($playerId)) {
                    return view('partial.alerts.application-alert', [
                        'type' => 'danger',
                        'status' => 'Ошибка!',
                        'message' => 'Переигровки не разрешены.'
                    ]);
                }
            }
        } else if ($tournament->squads()->find($squadId)->players()->find($playerId)) {
            return view('partial.alerts.application-alert', [
                'type' => 'danger',
                'status' => 'Ошибка!',
                'message' => 'Вы уже подали заяку на данный поток.'
            ]);
        } else if ($tournament->qualification->reentries + 1 == $playerEntries && $playerEntries > 0) {
            return view('partial.alerts.application-alert', [
                'type' => 'danger',
                'status' => 'Ошибка!',
                'message' => 'Максимальное число переигровок.'
            ]);
        }

        $tournament->squads()->find($squadId)->players()->save(User::find($playerId));

        return view('partial.alerts.application-alert', [
            'type' => 'success',
            'status' => 'Успех!',
            'message' => 'Заявка подана.'
        ]);
    }

    public function removeApplication(Request $request, $id)
    {
        $playerId = Auth::id();
        $sp = SquadPlayers::where('squad_id', $request->input('currentSquad'))
            ->where('player_id', $playerId)->first();
        $sp->delete();

        return back();
    }

    public function runQualificationConfirm($tournamentId, $currentSquadId)
    {
        $tournament = Tournament::find($tournamentId);
        if ($tournament->finished) {
            return redirect("/$tournamentId/results");
        }
        if ($currentSquadId != null) {
            $currentSquad = Squad::find($currentSquadId);
            if ($currentSquad->finished) {
                $nextSquadId = Tournament::find($tournamentId)->squads()
                    ->where('id', '>', $currentSquadId)
                    ->where('finished', false)
                    ->min('id');

                if ($nextSquadId == null) {
                    return redirect("/$tournamentId/run/q/rest");
                }

                $currentSquad = Squad::find($nextSquadId);
                $currentSquadId = $nextSquadId;
            }
        }
        return view('tournament.run.confirm', [
            'tournament' => $tournament,
            'part' => 'q',
            'stage' => 'conf',
            'players' => $currentSquad->players,
            'currentSquadId' => $currentSquadId
        ]);
    }

    public function runQualificationDraw(Request $request, $tournamentId, $currentSquadId)
    {
        if ($request->input('confirmed')) {
            $currentSquad = Squad::find($currentSquadId);
            foreach ($currentSquad->players as $key => $player) {
                if (!in_array($player->id, $request->input('confirmed'))) {
                    SquadPlayers::where('player_id', $player->id)
                        ->where('squad_id', $currentSquadId)
                        ->delete();
                    unset($currentSquad->players[$key]);
                }
            }

            return view('tournament.run.draw', [
                'tournament' => Tournament::find($tournamentId),
                'part' => 'q',
                'stage' => 'draw',
                'players' => $currentSquad->players,
                'currentSquadId' => $currentSquad->id
            ]);
        } else {
            return "Не выбрано ни одного игрока!";
        }
    }

    public function runQualificationGame(Request $request, $tournamentId, $currentSquadId)
    {
        $tournament = Tournament::find($tournamentId);
        $currentSquad = Squad::find($currentSquadId);
        $lanes = array_values(array_unique($request->input('lane')));
        $currentSquad->lanes = implode(',', $lanes);
        $currentSquad->save();

        $playedGames = array();
        foreach ($currentSquad->players as $index => $player) {
            $games = $player->games
                ->where('tournament_id', $tournamentId)
                ->where('part', 'q')
                ->where('squad_id', $currentSquadId);
            foreach ($games as $game) {
                $playedGames[$player->id][] = $game;
            }

            $player->lane = $request->lane[$index];
            $player->position = $request->position[$index];
        }

        return view('tournament.run.game', [
            'tournament' => $tournament,
            'part' => 'q',
            'stage' => 'game',
            'currentSquad' => $currentSquad,
            'currentSquadId' => $currentSquad->id,
            'players' => $currentSquad->players,
            'playedGames' => $playedGames,
            'lanes' => $lanes
        ]);
    }

    public function qualificationSquadResults(Request $request, $tournamentId, $currentSquadId)
    {
        $currentSquad = Squad::find($currentSquadId);
        $currentSquad->finished = true;
        $currentSquad->save();

        $playersResults = array();
        $playedGames = array();
        foreach ($currentSquad->players as $player) {
            $games = $player->games
                ->where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'q')
                ->where('squad_id', $currentSquadId);

            // $sum = 0;
            foreach ($games as $game) {
                $playedGames[$player->id][] = $game;
                // $sum += $game->result + $game->bonus;
            }
            // $avg = round($sum / $games->count(), 2);

            // $result = Result::firstOrNew(['player_id' => $player->id,
            //     'tournament_id' => $tournamentId,
            //     'part' => 'q',
            //     'squad_id' => $currentSquadId]);
            // $result->sum = $sum;
            // $result->avg = $avg;
            // $result->save();
            $result = Result::where('player_id', $player->id)
                              ->where('tournament_id', $tournamentId)
                              ->where('part', 'q')
                              ->where('squad_id', $currentSquadId)
                              ->first();
            $playersResults[$player->id] = $result;
        }

        $aPlayers = array();
        foreach($currentSquad->players as $player) {
          $aPlayers[] = $player;
        }

       $this->sortPlayersByResult($aPlayers, $tournamentId, 'q');

        return view('tournament.run.results-q-s', [
            'tournament' => Tournament::find($tournamentId),
            'part' => 'q',
            'stage' => 'rest',
            'players' => $aPlayers,
            'currentSquadId' => $currentSquadId,
            'playedGames' => $playedGames,
            'playersResults' => $playersResults
        ]);
    }

    public function qualificationResults($tournamentId)
    {
        $tournament = Tournament::find($tournamentId);
        $qPlayers = array();
        $qGames = array();
        $qResults = array();
        foreach ($tournament->squads as $squad) {
            foreach ($squad->players as $player) {
              $games = $player->games()
                  ->where('tournament_id', $tournament->id)
                  ->where('squad_id', $squad->id)
                  ->where('part', 'q')->get();

              $result = Result::where('tournament_id', $tournamentId)
                  ->where('player_id', $player->id)
                  ->where('part', 'q')
                  ->where('squad_id', $squad->id)
                  ->first();

              $extIndex = null;
              foreach ($qPlayers as $index => $q) {
                if ($q->id == $player->id) {
                  $extIndex = $index;
                  break;
                }
              }
              if (isset($extIndex)) {
                if ($qResults[$player->id]->sum < $result->sum) {
                  $qGames[$player->id] = $games;
                  $qResults[$player->id] = $result;
                }
              }
              else {
                array_push($qPlayers, $player);
                $qGames[$player->id] = $games;
                $qResults[$player->id] = $result;
              }
            }
        }

        $this->sortPlayersByResult($qPlayers, $tournamentId, 'q');
        session(['players' => $qPlayers]);

        return view('tournament.run.results-q', [
            'tournament' => $tournament,
            'part' => 'q',
            'stage' => '',
            'qPlayers' => $qPlayers,
            'qGames' => $qGames,
            'qResults' => $qResults]);
    }

    public static function sortPlayersByResult(&$players, $tournamentId, $part)
    {
        usort($players, function ($playerA, $playerB) use ($tournamentId, $part) {
            $playerAResult = $playerA['results']
                ->where('tournament_id', $tournamentId)
                ->where('part', $part)
                ->max('sum');
            $playerBResult = $playerB['results']
                ->where('tournament_id', $tournamentId)
                ->where('part', $part)
                ->max('sum');
            return ($playerAResult < $playerBResult);
        });
    }

    public function runRoundRobinConfirm(Request $request, $tournamentId)
    {
        $players = session('players');
        $tournament = Tournament::find($tournamentId);
        $finalistsCount = 1;

        if (!$tournament->roundRobin->players) {
          return TournamentController::getResults($tournamentId);
        }

        foreach ($players as $player) {
            if ($finalistsCount++ > $tournament->roundRobin->players) {
                $playerId = array_search($player, $players);
                unset($players[$playerId]);
            }
        }
        session(['players' => $players]);

        return view('tournament.run.confirm', [
            'tournament' => $tournament,
            'part' => 'rr',
            'stage' => 'conf',
            'players' => $players
        ]);
    }

    public function runRoundRobinDraw(Request $request, $tournamentId)
    {
        $tournament = Tournament::find($tournamentId);
        $players = session('players');
        foreach ($players as $key => $player) {
            if (!in_array($player->id, $request->input('confirmed'))) {
                unset($players[$key]);
            }
        }
        session(['players' => $players]);

        return view('tournament.run.draw', [
            'tournament' => $tournament,
            'part' => 'rr',
            'stage' => 'draw',
            'players' => $players
        ]);
    }

    public function runRoundRobinGame(Request $request, $tournamentId)
    {
        $players = session('players');
        $playedGames = array();
        $lanes = array_values(array_unique($request->input('lane')));

        foreach ($players as $index => $player) {
            $games = Game::where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'rr')->get();

            foreach ($games as $game) {
                $playedGames[$player->id][] = $game;
            }

            $player->lane = $request->lane[$index];
            $player->position = $request->position[$index];
        }

        $playersCount = count($players);
        $roundCount = ($playersCount % 2) ? $playersCount : $playersCount - 1;

        return view('tournament.run.game-rr', [
            'tournament' => Tournament::find($tournamentId),
            'part' => 'rr',
            'stage' => 'game',
            'players' => $players,
            'lastPlayerIndex' => $playersCount - 1,
            'roundCount' => $roundCount,
            'playedGames' => $playedGames,
            'lanes' => $lanes
        ]);
    }

    public function roundRobinResults(Request $request, $tournamentId)
    {
        $tournament = Tournament::find($tournamentId);
        $tournament->finished = true;
        $tournament->save();

        $players = session('players');
        $playedRoundRobinGames = array();
        $playersResults = array();
        $qualificationResults = array();
        foreach ($players as $player) {
            $roundRobinGames = Game::where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'rr')
                ->get();
            // $sum = 0;
            foreach ($roundRobinGames as $roundRobinGame) {
                $playedRoundRobinGames[$player->id][] = $roundRobinGame;
                // $sum += $roundRobinGame->result + $roundRobinGame->bonus;
            }
            // $avg = round($sum / $roundRobinGames->count(), 2);
            $qualificationResult = Result::where('tournament_id', $tournamentId)
                ->where('player_id', $player->id)
                ->where('part', 'q')
                ->max('sum');
            // $sum += $qualificationResult;
            // $roundRobinResult = Result::firstOrNew([
            //     'tournament_id' => $tournamentId,
            //     'player_id' => $player->id,
            //     'part' => 'rr',
            //     'sum' => $sum,
            //     'avg' => $avg
            // ]);
            // $roundRobinResult->save();
            $roundRobinResult = Result::where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'rr')
                ->first();

            $qualificationResults[$player->id] = $qualificationResult;
            $playersResults[$player->id] = $roundRobinResult;
        }

       $this->sortPlayersByResult($players, $tournamentId, 'rr');

        $playersCount = count($players);
        $roundCount = ($playersCount % 2) ? $playersCount : $playersCount - 1;

        return view('tournament.run.results-rr', [
            'tournament' => $tournament,
            'part' => 'rr',
            'stage' => 'rest',
            'fPlayers' => $players,
            'roundCount' => $roundCount,
            'fGames' => $playedRoundRobinGames,
            'fResults' => $playersResults,
            'qResults' => $qualificationResults
        ]);
    }

    private function getSquadResults($tournament, $squadId) {
      $squad = $tournament->squads()->where('id', $squadId)->first();

      $squadPlayers = array();
      $squadGames = array();
      $squadResults = array();

      foreach ($squad->players as $player) {
        $squadPlayers[] = $player;

        $games = Game::where('tournament_id', $tournament->id)
            ->where('player_id', $player->id)
            ->where('part', 'q')
            ->where('squad_id', $squad->id)
            ->get();
        $squadGames[$player->id] = $games;

        $results = Result::where('tournament_id', $tournament->id)
            ->where('player_id', $player->id)
            ->where('part', 'q')
            ->where('squad_id', $squad->id)
            ->first();
        $squadResults[$player->id] = $results;
      }

      // $this->sortPlayersByResult($squadPlayers, $tournament->id, 'q');

      $squad = new \stdClass;
      $squad->players = $squadPlayers;
      $squad->games = $squadGames;
      $squad->results = $squadResults;
      return $squad;
    }

    private function getQualificationResults($tournament) {
      $qPlayers = array();
      $qGames = array();
      $qResults = array();

      foreach ($tournament->squads as $squad) {
          foreach ($squad->players as $player) {
            $exists = false;
            foreach ($qPlayers as $key => $qPlayer) {
              if ($qPlayer->id == $player->id) {
                $exists = true;
                break;
              }
            }

            if (!$exists) {
            $qPlayers[] = $player;

            $maxSum = Result::where('tournament_id', $tournament->id)
                ->where('player_id', $player->id)
                ->where('part', 'q')
                ->max('sum');
            $qResult = Result::where('tournament_id', $tournament->id)
                ->where('player_id', $player->id)
                ->where('part', 'q')
                ->where('sum', $maxSum)
                ->first();
            $qResults[$player->id] = $qResult;

            $qualificationGames = Game::where('tournament_id', $tournament->id)
                ->where('player_id', $player->id)
                ->where('part', 'q')
                ->where('squad_id', $qResult->squad_id)
                ->get();
            $qGames[$player->id] = $qualificationGames;

            }
          }
      }

      $this->sortPlayersByResult($qPlayers, $tournament->id, 'q');

      $qualification = new \stdClass;
      $qualification->players = $qPlayers;
      $qualification->games = $qGames;
      $qualification->results = $qResults;

      return $qualification;
    }

    private function getRoundRobinResults($tournament) {
      $fGames = array();
      $fResults = array();
      $fPlayers = array();

      $roundRobinGames = Game::where('tournament_id', $tournament->id)
          ->where('part', 'rr')
          ->get();
      foreach ($roundRobinGames as $roundRobinGame) {
          $fPlayer = User::find($roundRobinGame->player_id);
          $fPlayers[$fPlayer->id] = $fPlayer;

          $fGames[$fPlayer->id][] = $roundRobinGame;

          $fResult = Result::where('tournament_id', $tournament->id)
              ->where('player_id', $fPlayer->id)
              ->where('part', 'rr')
              ->first();
          $fResults[$fPlayer->id] = $fResult;
      }

      $this->sortPlayersByResult($fPlayers, $tournament->id, 'rr');

      $roundRobin = new \stdClass;
      $roundRobin->players = $fPlayers;
      $roundRobin->games = $fGames;
      $roundRobin->results = $fResults;
      return $roundRobin;
    }

    public function getResults($tournamentId)
    {
        $tournament = Tournament::find($tournamentId);

        $squads = array();
        foreach ($tournament->squads as $squad) {
          $squads[] = $this->getSquadResults($tournament, $squad->id);
        }

        $qualification = $this->getQualificationResults($tournament);

        $roundRobin = $this->getRoundRobinResults($tournament);
        $roundCount = ($tournament->roundRobin->players % 2) ? $tournament->roundRobin->players : $tournament->roundRobin->players - 1;


        $allResults = $roundRobin->results;
        foreach ($qualification->results as $key => $result) {
          #???????
            if ($result && !isset($qualification->results[$result->player_id])) {
                $allResults[] = $result;
            }
        }

        usort($allResults, function ($resultA, $resultB) {
            return ($resultA->sum < $resultB->sum);
        });

        // return view('tournament.results', [
        //     'tournament' => $tournament,
        //     'qPlayers' => $qPlayers,
        //     'qGames' => $qGames,
        //     'qResults' => $qResults,
        //     'fPlayers' => $fPlayers,
        //     'fGames' => $fGames,
        //     'fResults' => $fResults,
        //     'roundCount' => $roundCount,
        //     'allResults' => $allResults
        // ]);
        return view('tournament.results', [
            'tournament' => $tournament,
            'squads' => $squads,
            'qualification' => $qualification,
            'roundRobin' => $roundRobin,
            'roundCount' => $roundCount,
            'allResults' => $allResults
        ]);
    }

    public function newTournament()
    {
         $admins = User::where('is_admin', 1)->get();
         return view('tournament.new-tournament', ['admins' => $admins]);
    }

    public function createTournament(Request $request)
    {
        $handicap = new Handicap([
            'type' => $request->handicap_type,
            'value' => $request->handicap_value,
            'max_game' => $request->handicap_max_game
        ]);
        $handicap->save();
        // echo $handicap;

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
        // echo $qualification;

        $roundRobin = new RoundRobin([
            'players' => $request->rr_players,
            'win_bonus' => $request->rr_win_bonus,
            'draw_bonus' => $request->rr_draw_bonus,
            'date' => $request->rr_date,
            'start_time' => $request->rr_start_time,
            'end_time' => $request->rr_end_time,
        ]);
        $roundRobin->save();
        // echo $roundRobin;

        $contact = User::find($request->contact_person);
        // echo $contact;

        $newTournament = new Tournament([
            'name' => $request->name,
            'location' => $request->location,
            'type' => $request->type,
            'oil_type' => $request->oil_type,
            'description' => $request->description,
            'handicap_id' => $handicap->id,
            'qualification_id' => $qualification->id,
            'roundrobin_id' => $roundRobin->id,
            'contact_id' => $contact->id,
            'finished' => false
        ]);
        $newTournament->save();

        $handicap->tournament_id = $newTournament->id;
        $handicap->save();

        $qualification->tournament_id = $newTournament->id;
        $qualification->save();

        $roundRobin->tournament_id = $newTournament->id;
        $roundRobin->save();

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

        // echo $newTournament;
        return redirect('/');
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


    $tournament->roundRobin->players = $request->rr_players;
    $tournament->roundRobin->win_bonus = $request->rr_win_bonus;
    $tournament->roundRobin->draw_bonus = $request->rr_draw_bonus;
    $tournament->roundRobin->date = $request->rr_date;
    $tournament->roundRobin->start_time = $request->rr_start_time;
    $tournament->roundRobin->end_time = $request->rr_end_time;
    $tournament->roundRobin->save();

    $contact = User::find($request->contact_person);
    $tournament->contact_id = $contact->id;

    foreach ($tournament->squads as $key => $squad) {
      if (!in_array($squad->id, $request->squad_id)) {
        echo "Delete squad ".$squad->id."<br>";
        $squad->delete();
      }
    }

    for ($i = 0; $i < $request->squads_count; ++$i) {
      $squad = $tournament->squads()->find($request->squad_id[$i]);
      if ($squad == null) {
        echo "New squad<br>";
        $squad = new Squad();
        $squad->tournament_id = $tournament->id;
        $squad->finished = false;
      }
      echo "Edit squad ".$request->squad_id[$i]."<br>";
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

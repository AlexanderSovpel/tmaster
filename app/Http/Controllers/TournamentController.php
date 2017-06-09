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
        $tournaments = Tournament::all()->sortByDesc('id');
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
        $squadId = $request->input('squad');

        $playerEntries = 0;
        foreach ($tournament->squads as $squad) {
            if ($squad->players()->find($playerId)) {
                $playerEntries += 1;
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
        } else if ($tournament->qualification->reentries + 1 > $playerEntries && $playerEntries > 0) {
            return view('partial.alerts.application-alert', [
                'type' => 'danger',
                'status' => 'Ошибка!',
                'message' => 'В потоке уже зарегистрировано максимальное количество участников.'
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

        return redirect('/');
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
            foreach ($currentSquad->players as $player) {
                if (!in_array($player->id, $request->input('confirmed'))) {
                    SquadPlayers::where('player_id', $player->id)
                        ->where('squad_id', $currentSquadId)
                        ->delete();
                    unset($player);
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
        $currentSquad = Squad::find($currentSquadId);
        $playedGames = array();
        foreach ($currentSquad->players as $player) {
            $games = $player->games
                ->where('tournament_id', $tournamentId)
                ->where('part', 'q')
                ->where('squad_id', $currentSquadId);
            foreach ($games as $game) {
                $playedGames[$player->id][] = $game;
            }
        }

        return view('tournament.run.game', [
            'tournament' => Tournament::find($tournamentId),
            'part' => 'q',
            'stage' => 'game',
            'currentSquadId' => $currentSquadId,
            'players' => $currentSquad->players,
            'playedGames' => $playedGames
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

            $sum = 0;
            foreach ($games as $game) {
                $playedGames[$player->id][] = $game;
                $sum += $game->result + $game->bonus;
            }
            $avg = round($sum / $games->count(), 2);

            $result = Result::firstOrNew([
                'tournament_id' => $tournamentId,
                'player_id' => $player->id,
                'part' => 'q',
                'sum' => $sum,
                'avg' => $avg
            ]);
            $result->save();
            $playersResults[$player->id] = $result;
        }

//        $this->sortPlayersByResult($currentSquad->players, $tournamentId, 'q');

        return view('tournament.run.results-q-s', [
            'tournament' => Tournament::find($tournamentId),
            'part' => 'q',
            'stage' => 'rest',
            'players' => $currentSquad->players,
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
                $qPlayers[] = $player;
                $games = $player->games()
                    ->where('tournament_id', $tournament->id)
                    ->where('part', 'q')->get();

                foreach ($games as $game) {
                    $qGames[$player->id][] = $game;
                }

                $result = Result::where('tournament_id', $tournamentId)
                    ->where('player_id', $player->id)
                    ->where('part', 'q')
                    ->first();
                $qResults[$player->id] = $result;
            }
        }

        $this->sortPlayersByResult($qPlayers, $tournamentId, 'q');

        return view('tournament.run.results-q', [
            'tournament' => $tournament,
            'part' => 'q',
            'stage' => '',
            'qPlayers' => $qPlayers,
            'qGames' => $qGames,
            'qResults' => $qResults]);
    }

    private function sortPlayersByResult(&$players, $tournamentId, $part)
    {
        usort($players, function ($playerA, $playerB) use ($tournamentId, $part) {
//            echo gettype((array)$playerA);
//
//            if (gettype($playerA) == 'object') {
//                $playerA = (array)$playerA;
//                $playerB = (array)$playerB;
//            }

            $playerAResult = $playerA['results']
                ->where('tournament_id', $tournamentId)
                ->where('part', $part)
                ->first();
            $playerBResult = $playerB['results']
                ->where('tournament_id', $tournamentId)
                ->where('part', $part)
                ->first();
            return ($playerAResult->sum < $playerBResult->sum);
        });
    }

    public function runRoundRobinConfirm(Request $request, $tournamentId)
    {
        $players = json_decode($request->input('players'));
        $tournament = Tournament::find($tournamentId);
        $finalistsCount = 1;

        foreach ($players as $player) {
            if ($finalistsCount++ > $tournament->roundRobin->players) {
                $playerId = array_search($player, $players);
                unset($players[$playerId]);
            }
        }

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
        $players = json_decode($request->input('players'));
        foreach ($players as $player) {
            if (!in_array($player->id, $request->input('confirmed'))) {
                unset($player);
            }
        }

        return view('tournament.run.draw', [
            'tournament' => $tournament,
            'part' => 'rr',
            'stage' => 'draw',
            'players' => $players
        ]);
    }

    public function runRoundRobinGame(Request $request, $tournamentId)
    {
        $players = json_decode($request->input('players'));
        $playedGames = array();
        foreach ($players as $player) {
            $games = Game::where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'rr')->get();

            foreach ($games as $game) {
                $playedGames[$player->id][] = $game;
            }
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
            'playedGames' => $playedGames
        ]);
    }

    public function roundRobinResults(Request $request, $tournamentId)
    {
        $players = json_decode($request->input('players'));
        $playedRoundRobinGames = array();
        $playersResults = array();
        $qualificationResults = array();
        foreach ($players as $player) {
            $roundRobinGames = Game::where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'rr')
                ->get();
            $sum = 0;
            foreach ($roundRobinGames as $roundRobinGame) {
                $playedRoundRobinGames[$player->id][] = $roundRobinGame;
                $sum += $roundRobinGame->result + $roundRobinGame->bonus;
            }
            $avg = round($sum / $roundRobinGames->count(), 2);
            $qualificationResult = Result::where('tournament_id', $tournamentId)
                ->where('player_id', $player->id)
                ->where('part', 'q')
                ->first();
            $sum += $qualificationResult->sum;
            $roundRobinResult = Result::firstOrNew([
                'tournament_id' => $tournamentId,
                'player_id' => $player->id,
                'part' => 'rr',
                'sum' => $sum,
                'avg' => $avg
            ]);
            $roundRobinResult->save();
            $qualificationResults[$player->id] = $qualificationResult;
            $playersResults[$player->id] = $roundRobinResult;
        }

////        echo gettype($players);
////        $players = array_values($players);
////        $this->sortPlayersByResult($players, $tournamentId, 'rr');
//
        $playersCount = count($players);
        $roundCount = ($playersCount % 2) ? $playersCount : $playersCount - 1;

        return view('tournament.run.results-rr', [
            'tournament' => Tournament::find($tournamentId),
            'part' => 'rr',
            'stage' => 'rest',
            'fPlayers' => $players,
            'roundCount' => $roundCount,
            'fGames' => $playedRoundRobinGames,
            'fResults' => $playersResults,
            'qResults' => $qualificationResults
        ]);
    }

    public function getResults($tournamentId)
    {
        $tournament = Tournament::find($tournamentId);
        $tournament->finished = true;
        $tournament->save();

        $qPlayers = array();
        $qGames = array();
        $qResults = array();
        foreach ($tournament->squads as $squad) {
            foreach ($squad->players as $player) {
                $qPlayers[] = $player;
                $qualificationGames = Game::where('tournament_id', $tournament->id)
                    ->where('player_id', $player->id)
                    ->where('part', 'q')->get();

                foreach ($qualificationGames as $game) {
                    $qGames[$player->id][] = $game;
                }

                $qResult = Result::where('tournament_id', $tournamentId)
                    ->where('player_id', $player->id)
                    ->where('part', 'q')
                    ->first();
                $qResults[$player->id] = $qResult;
            }
        }

        $this->sortPlayersByResult($qPlayers, $tournamentId, 'q');


        $fGames = array();
        $fResults = array();
        $fPlayers = array();
        $roundRobinGames = Game::where('tournament_id', $tournamentId)
            ->where('part', 'rr')
            ->get();
        foreach ($roundRobinGames as $roundRobinGame) {
            $fPlayer = User::find($roundRobinGame->player_id);
            $fPlayers[$fPlayer->id] = $fPlayer;

            $fGames[$fPlayer->id][] = $roundRobinGame;

            $fResult = Result::where('tournament_id', $tournamentId)
                ->where('player_id', $fPlayer->id)
                ->where('part', 'rr')
                ->first();
            $fResults[$fPlayer->id] = $fResult;
        }

        $fPlayersCount = count($fPlayers);
        $roundCount = ($fPlayersCount % 2) ? $fPlayersCount : $fPlayersCount - 1;

        $this->sortPlayersByResult($fPlayers, $tournamentId, 'rr');

        $allResults = $fResults;
        foreach ($qResults as $key => $result) {
            if (!isset($fResults[$result->player_id])) {
                $allResults[] = $result;
            }
        }

        usort($allResults, function ($resultA, $resultB) {
            return ($resultA->sum < $resultB->sum);
        });

        return view('tournament.results', [
            'tournament' => $tournament,
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

    public function newTournament()
    {
        // $admins = User::where('is_admin', 1)->get();
        // foreach ($admins as $key => $value) {
          // echo $value."<br>";
        // }
        // return view('tournament.new-tournament', ['admins' => $admins]);
        return view('tournament.new-tournament');
    }

    public function createTournament(Request $request)
    {
        $handicap = new Handicap([
            'type' => $request->handicap_type,
            'value' => $request->handicap_value,
            'max_game' => $request->handicap_max_game
        ]);
        $handicap->save();
        echo $handicap;

        $qualification = new Qualification([
            'entries' => $request->qualification_entries,
            'games' => $request->qualification_games,
            'finalists' => $request->qualification_finalists,
            'fee' => $request->qualification_fee,
            'allow_reentry' => $request->allow_reentry,
            'reentries' => $request->reentries_amount,
            'reentry_fee' => $request->reentry_fee
        ]);
        $qualification->save();
        echo $qualification;

        $roundRobin = new RoundRobin([
            'players' => $request->rr_players,
            'win_bonus' => $request->rr_win_bonus,
            'draw_bonus' => $request->rr_draw_bonus,
            'date' => $request->rr_date,
            'start_time' => $request->rr_start_time,
            'end_time' => $request->rr_end_time,
        ]);
        $roundRobin->save();
        echo $roundRobin;

        $contact = User::find($request->contact_person);
        echo $contact;

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

        echo $newTournament;
        // return redirect('/');
    }

    public function deleteTournament($tournamentId) {
      $tournament = Tournament::find($tournamentId);
      $tournament->delete();
      return redirect('/');
    }

}

<?php

namespace App\Http\Controllers;

use App\Result;
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
        $tournaments = Tournament::all();
        session()->put('tournaments', $tournaments);

        $user = Auth::user();

        return view('index', ['tournaments' => $tournaments, 'user' => $user]);
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
        echo $playerEntries;

        if ($tournament->allow_reentry == false) {
            foreach ($tournament->squads as $squad) {
                if ($squad->find($playerId)) {
                    return "reentries not allowed";
                }
            }
        } else if ($tournament->squads()->find($squadId)->players()->find($playerId)) {
            return "player has applied this squad";
        } else if ($tournament->reentries_amount + 1 > $playerEntries && $playerEntries > 0) {
            return "max reentries already";
        }

        $tournament->squads()->find($squadId)->players()->save(User::find($playerId));

        return redirect('/');
    }

    public function removeApplication(Request $request, $id)
    {
        $sp = SquadPlayers::where('squad_id', $request->input('currentSquad'))
            ->where('player_id', $request->input('player'))->get()[0];
        $sp->delete();

        return redirect('/');
    }

    public function runQualificationConfirm($tournamentId, $currentSquadId)
    {
        if ($currentSquadId != null) {
            $currentSquad = Squad::find($currentSquadId);
            if ($currentSquad->finished) {
                $nextSquad = Tournament::find($tournamentId)->squads()
                    ->where('id', '>', $currentSquadId)
                    ->min('id');

                if ($nextSquad == null) {
                    return redirect("/$tournamentId/run/q/rest");
                }

                $currentSquad = $nextSquad;
                $currentSquadId = $nextSquad->id;
            }
        }
        return view('tournament.run.confirm', [
            'tournamentId' => $tournamentId,
            'part' => 'q',
            'players' => $currentSquad->players,
            'currentSquadId' => $currentSquadId
        ]);
    }

    public function runQualificationDraw(Request $request, $tournamentId, $currentSquadId)
    {
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
            'tournamentId' => $tournamentId,
            'part' => 'q',
            'players' => $currentSquad->players,
            'currentSquadId' => $currentSquad->id
        ]);
    }

    public function runQualificationGame(Request $request, $tournamentId, $currentSquadId)
    {
        $currentSquad = Squad::find($currentSquadId);
        $playedGames = array();
        foreach ($currentSquad->players as $player) {
            $playedGames[$player->id] = $player->games
                ->where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'q')
                ->where('squad_id', $currentSquadId);
        }

        return view('tournament.run.game', [
            'tournamentId' => $tournamentId,
            'qualificationEntries' => Tournament::find($tournamentId)->qualification_entries,
            'currentSquadId' => $currentSquadId,
            'players' => $currentSquad->players,
            'playedGames' => $playedGames
        ]);
    }

    public function qualificationSquadResults($tournamentId, $currentSquadId)
    {
        $currentSquad = Squad::find($currentSquadId);
        $currentSquad->finished = true;
        $currentSquad->save();

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
            $avg = $sum / $games->count();

            $playersResults = array();
            $result = Result::firstOrNew([
                'tournament_id' => $tournamentId,
                'player_id' => $player->id,
                'part' => 'q',
                'sum' => $sum,
                'avg' => $avg
            ]);
            $playersResults[$player->id] = $result;
        }

        $this->sortPlayersByResult($currentSquad->players, $tournamentId, 'q');

        return view('tournament.run.results-q-s', [
            'tournamentId' => $tournamentId,
            'qualificationEntries' => Tournament::find($tournamentId)->qualification_entries,
            'players' => $currentSquad->players,
            'currentSquadId' => $currentSquadId,
            'playedGames' => $playedGames,
            'playersResults' => $playersResults
        ]);
    }

    public function qualificationResults($tournamentId)
    {
        $tournament = Tournament::find($tournamentId);
        $players = array();
        foreach ($tournament->squads as $squad) {
            foreach ($squad->players as $player) {
                $players[] = $player;
                $games = $player->games()
                    ->where('t_id', $tournament->id)
                    ->where('part', 'q')->get();

                foreach ($games as $game) {
                    $playedGames[$player->id][] = $game;
                }

                $playersResults = Result::where('tournament_id', $tournamentId)
                    ->where('player_id', $player->id)
                    ->where('part', 'q')
                    ->get();
            }
        }

        $this->sortPlayersByResult($players, $tournamentId, 'q');

        return view('tournament.run.results-q', [
            'tournamentId' => $tournamentId,
            'qualificationEntries' => $tournament->qualification_entries,
            'part' => 'q',
            'players' => $players,
            'playedGames' => $playedGames,
            'playersResults' => $playersResults]);
    }

    public function runRoundRobinConfirm(Request $request, $tournamentId)
    {
        $players = $request->input('players');
        $finalistsCount = 1;

        foreach ($players as $player) {
            if ($finalistsCount++ > Tournament::find($tournamentId)->rr_players) {
                unset($player);
            }
        }

        return view('tournament.run.confirm', [
            'tournamentId' => $tournamentId,
            'part' => 'rr',
            'players' => $players
        ]);
    }

    public function runRoundRobinDraw(Request $request, $tournamentId)
    {
        $players = $request->input('players');
        foreach ($players as $player) {
            if (!in_array($player->id, $request->input('confirmed'))) {
                unset($player);
            }
        }

        return view('tournament.run.draw', [
            'tournamentId' => $tournamentId,
            'part' => 'rr',
            'players' => $players
        ]);
    }

    public function runRoundRobinGame(Request $request, $tournamentId)
    {
        $players = $request->input('players');
        $playedGames = array();
        foreach ($players as $player) {
            $games = $player->games
                ->where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'rr');

            foreach ($games as $game) {
                $playedGames[$player->id][] = $game;
            }
        }

        $playersCount = count($players);
        $roundCount = ($playersCount % 2) ? $playersCount : $playersCount - 1;

        return view('tournament.run.game-rr', [
            'tournamentId' => $tournamentId,
            'part' => 'q',
            'players' => $players,
            'lastPlayerIndex' => $playersCount - 1,
            'roundCount' => $roundCount,
            'playedGames' => $playedGames
        ]);
    }

    //TODO: add qualification result to round-robin results
    public function roundRobinResults(Request $request, $tournamentId)
    {
        $players = $request->input('players');
        $playedGames = array();
        $playersResults = array();
        foreach ($players as $player) {
            $games = $player->games
                ->where('player_id', $player->id)
                ->where('tournament_id', $tournamentId)
                ->where('part', 'rr');

            $sum = 0;
            foreach ($games as $game) {
                $playedGames[$player->id][] = $game;
                $sum += $game->result + $game->bonus;
            }
            $avg = $sum / $games->count();

            $result = Result::firstOrNew([
                'tournament_id' => $tournamentId,
                'player_id' => $player->id,
                'part' => 'qq',
                'sum' => $sum,
                'avg' => $avg
            ]);
            $playersResults[$player->id] = $result;
        }

        $this->sortPlayersByResult($players, $tournamentId, 'rr');

        $playersCount = count($players);
        $roundCount = ($playersCount % 2) ? $playersCount : $playersCount - 1;

        return view('tournament.run.results-rr', [
            'tournamentId' => $tournamentId,
            'part' => 'rr',
            'players' => $players,
            'roundCount' => $roundCount,
            'playedGames' => $playedGames,
            'playersResults' => $playersResults
        ]);
    }

    //TODO: show overall results
    public function getResults($tournamentId)
    {
        return view('tournament.results');
    }

    private function sortPlayersByResult(&$players, $tournamentId, $part)
    {
        uasort($players, function ($playerA, $playerB) use ($tournamentId, $part) {
            $playerAResult = $playerA
                ->results()
                ->where('tournament_id', $tournamentId)
                ->where('part', $part)
                ->first();
            $playerBResult = $playerB
                ->results()
                ->where('tournament_id', $tournamentId)
                ->where('part', $part)
                ->first();
            return ($playerAResult->sum < $playerBResult->sum);
        });
    }
}

<?php

namespace App\Http\Controllers;

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
//        $this->tournaments = session('tournaments');
        $tournament = Tournament::find($id);

        return view('tournament.apply', ['tournament' => $tournament]);
    }

    public function postApplication(Request $request, $id)
    {
//        $this->tournaments = session('tournaments');
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



// part -- qualification or round-robin
//stage -- confirmation, drawing, game, results
    public function runTournament($id)
    {
        $this->tournaments = session('tournaments');
        $tournament = $this->findTournamentById($id);

        if (isset($tournament->state)) {
            if ($tournament->state == 'current') {
                $part = $tournament->part;
                $stage = $tournament->stage;
                $currentSquad = $tournament->currentSquad;

                switch ($part) {
                    case 'q':
                        switch ($stage) {
                            case 'conf':
                                $stage = 'draw';
                                ++$currentSquad;
                                break;
                            case 'draw':
                                break;
                            case 'game':
                                break;
                            case 'rest':
                                break;
                        }
                        break;
                    case 'rr':
                        switch ($stage) {
                            case 'conf':
                                break;
                            case 'draw':
                                break;
                            case 'game':
                                break;
                            case 'rest':
                                break;
                        }
                        break;
                }

                switch ($stage) {
                    case 'conf':
                        break;
                    case 'draw':
                        break;
                    case 'game':
                        break;
                    case 'rest':
                        break;
                }
                $part = $tournament->part;
                $stage = $tournament->stage;
            } else {
                //TODO: ???
            }
        } else {
            $tournament->state = 'current';
            $tournament->part = 0;
            $tournament->stage = 'q_reg';
        }

        session()->put('currentTournament', $tournament);

        return redirect()->action('TournamentController@runTournamentStage',
            ['part' => $tournament->part,
                'stage' => $tournament->stage]);
    }

    public function runTournamentStage($part, $stage)
    {
        $tournament = session('currentTournament');
    }

//    private function findTournamentById($id) {
//        foreach($this->tournaments as $tournament) {
//            if ($tournament->id == $id) {
//                return $tournament;
//            }
//        }
//
//        return null;
//    }
}

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Auth;

if (session()->has('tournament')) {
    $tournament = session('tournament');
}

Route::get('/', 'TournamentController@index');
Route::get('/{tournamentId}/details', 'TournamentController@details');
Route::get('/{id}/players', 'TournamentController@getTournamentPlayers');
Route::get('/{id}/apply', 'TournamentController@getApplication');
Route::post('/{id}/sendApplication', 'TournamentController@postApplication');
Route::post('/{id}/removeApplication', 'TournamentController@removeApplication');

Route::get('/{tournamentId}/run/q/conf/{currentSquadId}', 'TournamentController@runQualificationConfirm');
Route::get('/{tournamentId}/run/q/draw/{currentSquadId}', 'TournamentController@runQualificationDraw');
Route::get('/{tournamentId}/run/q/game/{currentSquadId}', 'TournamentController@runQualificationGame');
Route::post('/{tournamentId}/run/q/rest/{currentSquadId}', 'TournamentController@qualificationSquadResults');
Route::get('/{tournamentId}/run/q/rest', 'TournamentController@qualificationResults');

Route::get('/{tournamentId}/run/rr/conf/', 'TournamentController@runRoundRobinConfirm');
Route::get('/{tournamentId}/run/rr/draw', 'TournamentController@runRoundRobinDraw');
Route::get('/{tournamentId}/run/rr/game', 'TournamentController@runRoundRobinGame');
Route::post('/{tournamentId}/run/rr/rest', 'TournamentController@roundRobinResults');

Route::get('/{tournamentId}/results', 'TournamentController@getResults');
Route::get('/newTournament', 'TournamentController@newTournament');
Route::post('/saveTournament', 'TournamentController@saveTournament');
Route::get('/{tournamentId}/deleteTournament', 'TournamentController@deleteTournament');

Route::get('getSquadFilling/{id}', 'SquadController@getSquadFilling');

Route::get('/addSquadForm', 'Controller@addSquadForm');

Route::get('/account', 'UserController@showAccount');
Route::get('/account/edit', 'UserController@editAccount');
Route::post('/account/save', 'UserController@saveAccount');
Route::get('/getStatistic', 'UserController@getStatistic');

Route::post('saveTempImage', 'Controller@saveTempImage');
Auth::routes();

//Route::match(['get', 'post'], '/{id}/run/{part}/{stage}/{currentSquad?}',
//    function (Request $request, $id, $part, $stage, $currentSquadId = null) {
//        $tournament = \App\Tournament::find($id);
//
//        if ($part == 'q') {
//            $currentSquad = $tournament->squads()->find($currentSquadId);
//
//            if ($currentSquad->finished == true && $stage != 'rest') {
//                return redirect("/$id/run/$part/rest/$currentSquad->id");
//            }
//
//            switch ($stage) {
//                case 'conf': //+
//                    return view('tournament.run.confirm', ['tournament' => $tournament,
//                        'part' => $part,
//                        'stage' => $stage,
//                        'players' => $currentSquad->players,
//                        'currentSquadId' => $currentSquad->id,
//                        'squadFinished' => $request->input('squadFinished')
//                    ]);
//                    break;
//
//                case 'draw': //+
//                    foreach ($currentSquad->players as $player) {
//                        if (!in_array($player->id, $request->input('confirmed'))) {
//                            \App\SquadPlayers::where('player_id', $player->id)
//                                ->where('squad_id', $currentSquadId)
//                                ->delete();
//                            unset($player);
//                        }
//                    }
//
//                    return view('tournament.run.draw', ['tournament' => $tournament,
//                        'part' => $part,
//                        'stage' => $stage,
//                        'players' => $currentSquad->players,
//                        'currentSquadId' => $currentSquad->id,
//                        'squadFinished' => $request->input('squadFinished')
//                    ]);
//                    break;
//
//                case 'game': //+
//                    foreach ($currentSquad->players as $player) {
//                        $playedGames[$player->id] = $player->games
//                            ->where('p_id', $player->id)
//                            ->where('t_id', $tournament->id)
//                            ->where('part', $part)
//                            ->where('s_id', $currentSquadId);
//                    }
//
//                    return view('tournament.run.game', ['tournament' => $tournament,
//                        'part' => $part,
//                        'stage' => $stage,
//                        'players' => $currentSquad->players,
//                        'currentSquadId' => $currentSquad->id,
//                        'squadFinished' => $request->input('squadFinished'),
//                        'playedGames' => $playedGames
//                    ]);
//                    break;
//
//                case 'rest': //+
//                    $currentSquad->finished = true;
//                    $currentSquad->save();
//                    foreach ($currentSquad->players as $player) {
//                        $playedGames[$player->id] = $player->games
//                            ->where('p_id', $player->id)
//                            ->where('t_id', $tournament->id)
//                            ->where('part', $part)
//                            ->where('s_id', $currentSquadId);
//                    }
//
//                    return view('tournament.run.results', ['tournament' => $tournament,
//                        'part' => $part,
//                        'stage' => $stage,
//                        'players' => $currentSquad->players,
//                        'currentSquadId' => $currentSquad->id,
//                        'squadFinished' => $request->input('squadFinished'),
//                        'playedGames' => $playedGames
//                    ]);
//                    break;
//            }
//        }
//
//        if ($part == 'rr') {
//            foreach ($tournament->squads as $squad) {
//                foreach ($squad->players as $player) {
//                    $playerGames = $player->games()->where('t_id', $tournament->id)
//                        ->where('part', 'q')->get();
//                    $gamesSum = 0;
//                    foreach ($playerGames as $game) {
//                        $gamesSum += $game->result;
//                    }
//                    $playerResult[$player->id] = $gamesSum;
//                }
//            }
//            arsort($playerResult);
//
//            $playersCount = 1;
//            foreach ($playerResult as $playerId => $result) {
//                if ($playersCount++ > $tournament->rr_players) {
//                    unset($playerResult[$playerId]);
//                }
//            }
//
//            foreach ($playerResult as $key => $value) {
//                $finalists[] = \App\User::find($key);
//            }
//
//            switch ($stage) {
//                case 'conf': //+
//                    return view('tournament.run.confirm', ['tournament' => $tournament,
//                        'part' => $part,
//                        'stage' => $stage,
//                        'players' => $finalists
//                    ]);
//                    break;
//
//                case 'draw': //+
//                    foreach ($finalists as $player) {
//                        if (!in_array($player->id, $request->input('confirmed'))) {
//                            unset($player);
//                        }
//                    }
//
//                    return view('tournament.run.draw', ['tournament' => $tournament,
//                        'part' => $part,
//                        'stage' => $stage,
//                        'players' => $finalists
//                    ]);
//                    break;
//
//                case 'game': //+
//                    foreach ($finalists as $player) {
//                        $g = $player->games
//                            ->where('p_id', $player->id)
//                            ->where('t_id', $tournament->id)
//                            ->where('part', $part);
//
//                        foreach ($g as $key => $value) {
//                            $playedGames[$player->id][] = $value;
//                        }
//                    }
//
//                    return view('tournament.run.game-rr', ['tournament' => $tournament,
//                        'part' => $part,
//                        'stage' => $stage,
//                        'players' => $finalists,
//                        'lastPlayerIndex' => count($finalists) - 1,
//                        'roundCount' => $tournament->rr_players - 1,
//                        'playedGames' => $playedGames
//                    ]);
//                    break;
//
//                case 'rest': //+
//                    foreach ($finalists as $player) {
//                        $g = $player->games
//                            ->where('p_id', $player->id)
//                            ->where('t_id', $tournament->id)
//                            ->where('part', $part);
//
//                        $sum = 0;
//                        foreach ($g as $key => $value) {
//                            $playedGames[$player->id][] = $value;
//                            $sum += $value->result + $value->bonus;
//                        }
//                        $avg = $sum / $g->count();
//
//                        $r = \App\Result::firstOrNew([
//                            'tournament_id' => $tournament->id,
//                            'player_id' => $player->id,
//                            'part' => $part,
//                            'sum' => $sum,
//                            'avg' => $avg
//                        ]);
//                        $playersResults[$player->id] = $r;
//                    }
//
//                    $tournamentId = $tournament->id;
//                    uasort($finalists, function($playerA, $playerB) use ($tournamentId, $part) {
//                        $playerAResult = $playerA
//                            ->results()
//                            ->where('tournament_id', $tournamentId)
//                            ->where('part', $part)
//                            ->first();
//                        $playerBResult = $playerB
//                            ->results()
//                            ->where('tournament_id', $tournamentId)
//                            ->where('part', $part)
//                            ->first();
//                        return ($playerAResult->sum < $playerBResult->sum);
//                    });
//
//                    return view('tournament.run.results-rr', ['tournament' => $tournament,
//                        'part' => $part,
//                        'stage' => $stage,
//                        'players' => $finalists,
//                        'roundCount' => $tournament->rr_players - 1,
//                        'playedGames' => $playedGames,
//                        'playersResults' => $playersResults
//                    ]);
//                    break;
//            }
//        }
//    });
//
//Route::post('/{id}/run/{part}', function (Request $request, $id, $part) {
//    $tournament = \App\Tournament::find($id);
//
//    switch ($part) {
//        case 'q': //+
//            $players = array();
//            foreach ($tournament->squads as $squad) {
//                foreach ($squad->players as $player) {
//                    $players[] = $player;
//                    $playedGames[$player->id] = $player->games()
//                        ->where('t_id', $tournament->id)
//                        ->where('part', 'q')->get();
//                }
//            }
//            arsort($playedGames);
//
//            return view('tournament.run.qualification', ['tournament' => $tournament,
//                'part' => $part,
//                'stage' => '',
//                'players' => $players,
//                'playedGames' => $playedGames]);
//            break;
//        case 'rr':
//            break;
//    }
//});

Route::get('/setGameResult', 'GameController@setResult');
Route::get('/changeGameResult', 'GameController@changeResult');
Route::get('/sumBlock', 'GameController@sumBlock');
Route::get('/updateBonus', 'GameController@updateBonus');

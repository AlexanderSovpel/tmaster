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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

if (session()->has('tournament')) {
    $tournament = session('tournament');
}

Route::get('/', 'TournamentController@index');
Route::get('/{id}/players', 'TournamentController@getTournamentPlayers');
Route::get('/{id}/apply', 'TournamentController@getApplication');
Route::post('/{id}/sendApplication', 'TournamentController@postApplication');
Route::post('/{id}/removeApplication', 'TournamentController@removeApplication');

Route::get('getSquadFilling/{id}', 'SquadController@getSquadFilling');

Auth::routes();

Route::match(['get', 'post'], '/{id}/run/{part}/{stage}/{currentSquad?}',
    function (Request $request, $id, $part, $stage, $currentSquadId = null) {
        $tournament = \App\Tournament::find($id);

        if ($part == 'q') {
            $currentSquad = $tournament->squads()->find($currentSquadId);

            if ($currentSquad->finished == true && $stage != 'rest') {
                return redirect("/$id/run/$part/rest/$currentSquad->id");
            }

            switch ($stage) {
                case 'conf':
                    return view('tournament.run.confirm', ['tournament' => $tournament,
                        'part' => $part,
                        'stage' => $stage,
                        'players' => $currentSquad->players,
                        'currentSquadId' => $currentSquad->id,
                        'squadFinished' => $request->input('squadFinished')
                    ]);
                    break;

                case 'draw':
                    foreach ($currentSquad->players as $player) {
                        if (!in_array($player->id, $request->input('confirmed'))) {
                            \App\SquadPlayers::where('player_id', $player->id)
                                ->where('squad_id', $currentSquadId)
                                ->delete();
                            unset($player);
                        }
                    }

                    return view('tournament.run.draw', ['tournament' => $tournament,
                        'part' => $part,
                        'stage' => $stage,
                        'players' => $currentSquad->players,
                        'currentSquadId' => $currentSquad->id,
                        'squadFinished' => $request->input('squadFinished')
                    ]);
                    break;

                case 'game':
                    foreach ($currentSquad->players as $player) {
                        $playedGames[$player->id] = $player->games
                            ->where('p_id', $player->id)
                            ->where('t_id', $tournament->id)
                            ->where('stage', $part)
                            ->where('s_id', $currentSquadId);
                    }

                    return view('tournament.run.game', ['tournament' => $tournament,
                        'part' => $part,
                        'stage' => $stage,
                        'players' => $currentSquad->players,
                        'currentSquadId' => $currentSquad->id,
                        'squadFinished' => $request->input('squadFinished'),
                        'playedGames' => $playedGames
                    ]);
                    break;

                case 'rest':
                    $currentSquad->finished = true;
                    $currentSquad->save();
                    foreach ($currentSquad->players as $player) {
                        $playedGames[$player->id] = $player->games
                            ->where('p_id', $player->id)
                            ->where('t_id', $tournament->id)
                            ->where('part', $part)
                            ->where('s_id', $currentSquadId);
                    }

                    return view('tournament.run.results', ['tournament' => $tournament,
                        'part' => $part,
                        'stage' => $stage,
                        'currentSquad' => $currentSquad,
                        'squadFinished' => $request->input('squadFinished'),
                        'playedGames' => $playedGames
                    ]);
                    break;
            }
        }

        if ($part == 'rr') {
            foreach ($tournament->squads as $squad) {
                foreach ($squad->players as $player) {
                    $playerGames = $player->games()->where('t_id', $tournament->id)
                        ->where('part', 'q')->get();
                    $gamesSum = 0;
                    foreach ($playerGames as $game) {
                        $gamesSum += $game->result;
                    }
                    $playerResult[$player->id] = $gamesSum;
                }
            }
            arsort($playerResult);

            $playersCount = 1;
            foreach ($playerResult as $r) {
                ++$playersCount;
                if ($playersCount > $tournament->rr_players)
                    unset($r);
            }

            foreach ($playerResult as $key => $value) {
                $finalists[] = \App\User::find($key);
            }

//        $finalistsIds = array_keys($playerResult);
//        foreach ($finalistsIds as $finalistsId) {
//            $finalist = \App\User::find($finalistsId);
//            $finalists[] = $finalist;
//        }

            switch ($stage) {
                case 'conf':
                    return view('tournament.run.confirm', ['tournament' => $tournament,
                        'part' => $part,
                        'stage' => $stage,
                        'players' => $finalists
                    ]);
                    break;

                case 'draw':
                    foreach ($finalists as $player) {
                        if (!in_array($player->id, $request->input('confirmed'))) {
                            unset($player);
                        }
                    }

                    return view('tournament.run.draw', ['tournament' => $tournament,
                        'part' => $part,
                        'stage' => $stage,
                        'players' => $finalists
                    ]);
                    break;

                case 'game':
                    foreach ($finalists as $player) {
                        $playedGames[$player->id] = $player->games
                            ->where('p_id', $player->id)
                            ->where('t_id', $tournament->id)
                            ->where('part', $part);
                    }

                    return view('tournament.run.game-rr', ['tournament' => $tournament,
                        'part' => $part,
                        'stage' => $stage,
                        'players' => $finalists,
                        'lastPlayerIndex' => count($finalists) - 1,
                        'roundCount' => $tournament->rr_players - 1,
                        'playedGames' => $playedGames
                    ]);
                    break;

                case 'rest':
                    break;
            }
        }
    });

Route::get('/{id}/run/q', function ($id) {
    $tournament = \App\Tournament::find($id);

    foreach ($tournament->squads as $squad) {
        foreach ($squad->players as $player) {
            $playerGames = $player->games()->where('t_id', $tournament->id)
                ->where('part', 'q')->get();
            $gamesSum = 0;
            foreach ($playerGames as $game) {
                $gamesSum += $game->result;
            }
            $playerResult[$player->id] = $gamesSum;
//            $playerResult[$player->surname . ' ' . $player->name] = $gamesSum;
        }
    }
    arsort($playerResult);

    return view('tournament.run.qualification',
        ['tournament' => $tournament,
            'playerResult' => $playerResult]);
});

Route::get('/setGameResult', 'GameController@setResult');
Route::get('/changeGameResult', 'GameController@changeResult');
Route::get('/sumBlock', 'GameController@sumBlock');
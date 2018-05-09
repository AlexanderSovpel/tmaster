<?php
namespace App\Http\Controllers;

use App\Squad;
use App\SquadPlayers;
use App\Tournament;

use App\Http\Controllers\TournamentController;

use Illuminate\Http\Request;

class QualificationController extends StageController {
  public function confirm(int $tournamentId, int $currentSquadId = null) {
    $tournament = Tournament::find($tournamentId);

    if ($tournament->finished) {
      return redirect("/$tournamentId/results");
    }

    if ($currentSquadId !== null) {
      $currentSquad = Squad::find($currentSquadId);

      if ($currentSquad->finished) {
        $nextSquadId = Tournament::find($tournamentId)->squads()
          ->where('id', '>', $currentSquadId)
          ->where('finished', false)
          ->min('id');

        if ($nextSquadId === null) {
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
      'players' => $currentSquad->players()->orderBy('surname', 'ASC')->get(),
      'currentSquadId' => $currentSquadId,
      'currentSquad' => $currentSquad
    ]);
  }

  public function draw(Request $request, int $tournamentId, int $currentSquadId = null) {
    if ($request->input('confirmed')) {
      $currentSquad = Squad::find($currentSquadId);
      $presentPlayers = array();

      foreach ($currentSquad->players as $key => $player) {
        $squadPlayer = SquadPlayers::where('player_id', $player->id)
          ->where('squad_id', $currentSquadId)
          ->first();

        if (in_array($player->id, $request->input('confirmed'))) {
            $squadPlayer->present = true;
            $presentPlayers[] = $player;
        }
        else {
          $squadPlayer->present = false;
        }

        $squadPlayer->save();
      }

      session(['players' => $presentPlayers]);

      return view('tournament.run.draw', [
        'tournament' => Tournament::find($tournamentId),
        'part' => 'q',
        'stage' => 'draw',
        'players' => $presentPlayers,
        'currentSquadId' => $currentSquad->id
      ]);
    } else {
      // TODO: Write some error view
      return "Не выбрано ни одного игрока!";
    }
  }

  public function game(Request $request, int $tournamentId, int $currentSquadId = null) {
    $tournament = Tournament::find($tournamentId);

    $lanes = array_values(array_unique($request->input('lane')));
    sort($lanes);

    $playersLanes = array();

    $currentSquad = Squad::find($currentSquadId);
    $currentSquad->lanes = implode(',', $lanes);
    $currentSquad->save();

    $players = session('players');

    $playedGames = array();

    foreach($players as $index => $player) {
      $games = $player->games
        ->where('tournament_id', $tournamentId)
        ->where('part', 'q')
        ->where('squad_id', $currentSquadId);

      foreach ($games as $game) {
        $playedGames[$player->id][] = $game;
      }

      $playersLanes[$index] = $request->lane[$index];
    }

    return view('tournament.run.game', [
      'tournament' => $tournament,
      'part' => 'q',
      'stage' => 'game',
      'currentSquad' => $currentSquad,
      'currentSquadId' => $currentSquadId,
      'players' => $players,
      'playedGames' => $playedGames,
      'lanes' => $lanes,
      'playersLanes' => $playersLanes
    ]);
  }

  public function results(int $tournamentId) {
    $tournament = Tournament::find($tournamentId);
    $qPlayers = array();
    $qGames = array();
    $qResults = array();
    list($qPlayers, $qGames, $qResults) = TournamentController::getQualificationResults($tournament);

    session(['players' => $qPlayers]);

    return view('tournament.run.results-q', [
      'tournament' => $tournament,
      'part' => 'q',
      'stage' => '',
      'qPlayers' => $qPlayers,
      'qGames' => $qGames,
      'qResults' => $qResults]);
  }

  public function squadResults(int $tournamentId, int $currentSquadId) {
    $tournament = Tournament::find($tournamentId);

    $currentSquad = Squad::find($currentSquadId);
    $currentSquad->finished = true;
    $currentSquad->save();

    $playersResults = array();
    $playedGames = array();
    $aPlayers = array();
    list($aPlayers, $playedGames, $playersResults) = TournamentController::getSquadResults($tournament, $currentSquad);

    return view('tournament.run.results-q-s', [
        'tournament' => $tournament,
        'part' => 'q',
        'stage' => 'rest',
        'players' => $aPlayers,
        'currentSquadId' => $currentSquadId,
        'playedGames' => $playedGames,
        'playersResults' => $playersResults
    ]);
  }
}
?>

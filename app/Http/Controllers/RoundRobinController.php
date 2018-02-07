<?php
namespace App\Http\Controllers;

use App\Game;
use App\Result;
use App\Tournament;

use App\Http\Controllers\TournamentController;

use Illuminate\Http\Request;

class RoundRobinController extends StageController {
  public function confirm(int $tournamentId) {
    $tournament = Tournament::find($tournamentId);

    if (isset($tournament->roundRobin) === false) {
      $tournament->finished = true;
      $tournament->save();
      return redirect($tournament->id . '/results');
    }

    $players = session('players');
    $finalistsCount = 1;

    // ???
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

  public function draw(Request $request, int $tournamentId) {
    $tournament = Tournament::find($tournamentId);
    $players = session('players');
    $presentPlayers = array();

    foreach ($players as $key => $player) {
      if (in_array($player->id, $request->input('confirmed'))) {
        $presentPlayers[] = $player;
      }
    }

    session(['players' => $presentPlayers]);

    return view('tournament.run.draw', [
      'tournament' => $tournament,
      'part' => 'rr',
      'stage' => 'draw',
      'players' => $presentPlayers
    ]);
  }

  public function game(Request $request, int $tournamentId) {
    $players = session('players');
    $playersCount = count($players);
    $playedGames = array();

    $lanes = array_values(array_unique($request->input('lane')));
    sort($lanes);

    $playersLanes = array();

    for ($i = 0; $i < $playersCount; ++$i) {
      $games = Game::where('player_id', $players[$i]->id)
        ->where('tournament_id', $tournamentId)
        ->where('part', 'rr')->get();

      foreach ($games as $game) {
        $playedGames[$players[$i]->id][] = $game;
      }

      $playersLanes[] = $request->lane[$i];
    }

    $roundCount = ($playersCount % 2) ? $playersCount : $playersCount - 1;

    return view('tournament.run.game-rr', [
      'tournament' => Tournament::find($tournamentId),
      'part' => 'rr',
      'stage' => 'game',
      'players' => $players,
      'lastPlayerIndex' => $playersCount - 1,
      'roundCount' => $roundCount,
      'playedGames' => $playedGames,
      'lanes' => $lanes,
      'playersLanes' => $playersLanes
    ]);
  }

  public function results(int $tournamentId) {
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

      foreach ($roundRobinGames as $roundRobinGame) {
        $playedRoundRobinGames[$player->id][] = $roundRobinGame;
      }

      $qualificationResult = Result::where('tournament_id', $tournamentId)
        ->where('player_id', $player->id)
        ->where('part', 'q')
        ->max('sum');

      $roundRobinResult = Result::where('player_id', $player->id)
        ->where('tournament_id', $tournamentId)
        ->where('part', 'rr')
        ->first();

      $qualificationResults[$player->id] = $qualificationResult;
      $playersResults[$player->id] = $roundRobinResult;
    }

    TournamentController::sortPlayersByResult($players, $tournamentId, 'rr', null);

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
}
?>
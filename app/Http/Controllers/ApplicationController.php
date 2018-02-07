<?php
namespace App\Http\Controllers;

use App\SquadPlayers;
use App\Tournament;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller {
  public function index(int $tournamentId) {
    $tournament = Tournament::find($tournamentId);
    return view('tournament.apply', ['tournament' => $tournament]);
  }

  public function post(Request $request, int $tournamentId)
  {
    $tournament = Tournament::find($tournamentId);
    $playerId = Auth::id();

    if ($request->has('player_id')) {
      $playerId = $request->player_id;
    }

    $squadId = $request->input('squad');

    $playerEntries = 0;
    foreach ($tournament->squads as $squad) {
      if ($squad->players()->find($playerId)) {
        $playerEntries += 1;
      }
    }

    if ($tournament->qualification->allow_reentry === false) {
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
    } else if ($tournament->qualification->reentries + 1 === $playerEntries && $playerEntries > 0) {
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

  public function remove(Request $request, int $tournamentId, int $playerId)
  {
    if ($playerId === null) {
      $playerId = Auth::id();
    }
    $sp = SquadPlayers::where('squad_id', $request->input('currentSquad'))
      ->where('player_id', $playerId)->first();
    $sp->delete();

    return back();
  }
}
?>

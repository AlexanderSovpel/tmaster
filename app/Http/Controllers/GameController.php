<?php

namespace App\Http\Controllers;

use App\Game;
use App\Result;
use App\Tournament;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function setResult(Request $request)
    {
        $game = new Game(['player_id' => $request->input('player_id'),
            'tournament_id' => $request->input('tournament_id'),
            'part' => $request->input('part'),
            'squad_id' => $request->input('squad_id'),
            'result' => $request->input('result'),
            'bonus' => $request->input('bonus'),
            'date' => date("Y-m-d")]);
        $game->save();

        $result = $this->countBlockResult($request);

        return array($game, $result);
    }

    public function changeResult(Request $request)
    {
        //TODO: если есть несколько игр с одинаковым результатом, изменяется значение первой,
        //TODO: а не фактически редактируемой
        $game = Game::where('player_id', $request->input('player_id'))
            ->where('tournament_id', $request->input('tournament_id'))
            ->where('part', $request->input('part'))
            ->where('squad_id', $request->input('squad_id'))
            ->where('result', $request->input('oldResult'))
            ->first();

        $game->result = $request->input('newResult');
        $game->bonus = $request->input('bonus');
        $game->save();

        $result = $this->countBlockResult($request);

        return array($game, $result);
    }

    public function changeById(Request $request) {
      $game = Game::find($request->id);

      if ($game) {
        $game->result = ($request->has('result')) ? $request->result : $game->result;
        $game->bonus = ($request->has('bonus')) ? $request->bonus : $game->bonus;
        $game->save();
      }

      return $game;
    }

    public function updateBonus(Request $request)
    {
        $game = Game::where('player_id', $request->input('player_id'))
            ->where('tournament_id', $request->input('tournament_id'))
            ->where('part', $request->input('part'))
            ->where('squad_id', $request->input('squad_id'))
            ->where('result', $request->input('result'))
            ->where('bonus', $request->input('oldBonus'))
            ->get()[0];
        $game->bonus = $request->input('newBonus');
        $game->save();

        $result = $this->countBlockResult($request);

        return array($game, $result);
    }

    private function countBlockResult(Request $request) {
      $tournament = Tournament::find($request->input('tournament_id'));
      $maxHandicap = $tournament->handicap->max_game;

      $games = Game::where('player_id', $request->player_id)
          ->where('tournament_id', $request->tournament_id)
          ->where('part', $request->part)
          ->where('squad_id', $request->squad_id)
          ->get();

      $avg = 0;
      $sum = 0;
      foreach ($games as $game) {
        if ($request->part == 'q' && $game->result + $game->bonus > $maxHandicap) {
          $sum += $maxHandicap;
        }
        else {
          $sum += $game->result + $game->bonus;
        }
      }
      $avg = round($sum / count($games), 2);

      if ($request->part == 'rr') {
        $qualificationResult = Result::where('player_id', $request->input('player_id'))
            ->where('tournament_id', $request->input('tournament_id'))
            ->where('part', 'q')
            ->max('sum');
        $sum += $qualificationResult;
      }

      $result = Result::firstOrNew(['player_id' => $request->input('player_id'),
          'tournament_id' => $request->input('tournament_id'),
          'part' => $request->input('part'),
          'squad_id' => $request->input('squad_id')]);
      $result->squad_id = $request->input('squad_id');
      $result->sum = $sum;
      $result->avg = $avg;
      $result->save();
      return $result;
    }

// зачем эта функция?
    // public function sumBlock(Request $request)
    // {
    //     $games = Game::where('player_id', $request->input('player_id'))
    //         ->where('tournament_id', $request->input('tournament_id'))
    //         ->where('part', $request->input('part'));
    //
    //     if ($request->input('part') == 'q' && $request->input('squad_id') != '') {
    //         $games = $games->where('squad_id', $request->input('squad_id'))->get();
    //     } else {
    //         $games = $games->get();
    //     }
    //
    //     $result = 0;
    //     foreach ($games as $game) {
    //         $result += $game->result + $game->bonus;
    //     }
    //     return $result;
    // }
}

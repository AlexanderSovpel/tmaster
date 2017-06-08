<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function setResult(Request $request)
    {
        $game = new Game();
        $game->player_id = $request->player_id;
        $game->tournament_id = $request->tournament_id;
        $game->part = $request->part;
        $game->squad_id = $request->squad_id;
        $game->result = $request->result;
        $game->bonus = $request->bonus;
        $game->date = date("Y-m-d");
//        $game = new Game(['player_id' => $request->input('player_id'),
//            'tournament_id' => $request->input('tournament_id'),
//            'part' => $request->input('part'),
//            'squad_id' => $request->input('squad_id'),
//            'result' => $request->input('result'),
//            'bonus' => $request->input('bonus'),
//            'date' => date("Y-m-d")]);
//
        $game->save();
        return "game created: ".$game;
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
        return "game changed";
    }

    public function sumBlock(Request $request)
    {
        $games = Game::where('player_id', $request->input('player_id'))
            ->where('tournament_id', $request->input('tournament_id'))
            ->where('part', $request->input('part'));

        if ($request->input('part') == 'q' && $request->input('squad_id') != '') {
            $games = $games->where('squad_id', $request->input('squad_id'))->get();
        } else {
            $games = $games->get();
        }

        $result = 0;
        foreach ($games as $game) {
            $result += $game->result + $game->bonus;
        }
        return $result;
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

        // echo "$game\n";
        $game->bonus = $request->input('newBonus');
        // echo "$game\n";
        $game->save();
        return "old bonus: " . $request->input('oldBonus') . ", new bonus: " . $request->input('newBonus');
    }
}

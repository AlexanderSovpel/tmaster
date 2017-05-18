<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function setResult(Request $request)
    {
        $game = new Game(['p_id' => $request->input('player_id'),
            't_id' => $request->input('tournament_id'),
            'stage' => $request->input('stage'),
            's_id' => $request->input('squad_id'),
            'result' => $request->input('result'),
            'date' => date("Y-m-d")]);

        $game->save();
        return "game created";
    }

    public function changeResult(Request $request)
    {
        //TODO: если есть несколько игр с одинаковым результатом, изменяется значение первой,
        //TODO: а не фактически редактируемой
        $game = Game::where('p_id', $request->input('player_id'))
            ->where('t_id', $request->input('tournament_id'))
            ->where('stage', $request->input('stage'))
            ->where('s_id', $request->input('squad_id'))
            ->where('result', $request->input('oldResult'))
            ->get()[0];

        $game->result = $request->input('newResult');
        $game->save();
        return "game changed";
    }

    public function sumBlock(Request $request)
    {
        $games = Game::where('p_id', $request->input('player_id'))
            ->where('t_id', $request->input('tournament_id'))
            ->where('stage', $request->input('stage'));

        if ($request->input('stage') == 'q') {
            $games = $games->where('s_id', $request->input('squad_id'))->get();
        } else {
            $games = $games->get();
        }

        $result = $games->sum('result') + $request->input('handicap') * $games->count();
        return $result;
    }
}

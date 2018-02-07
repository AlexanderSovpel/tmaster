<?php

namespace App\Http\Controllers;

use App\Squad;
use Illuminate\Http\Request;

class SquadController extends Controller
{
  public function __construct()
  {
      // $this->middleware('auth');
  }

    public function getSquadFilling($squadId)
    {
        $squad = Squad::find($squadId);

        $response = [
            'squadId' => $squad->id,
            'playersCount' => $squad->players()->count(),
            'maxPlayers' => $squad->max_players,
            'players' => $squad->players
        ];

        return json_encode($response);
    }

    public function addSquadForm(Request $request)
    {
        return view('partial.squad-form', ['index' => $request->index]);
    }
}

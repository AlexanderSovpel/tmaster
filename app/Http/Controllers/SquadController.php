<?php

namespace App\Http\Controllers;

use App\Squad;

class SquadController extends Controller
{
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
}

<table>
    <tr class="results-header">
        <td>Участник</td>
        <td>Квалификация</td>
        @for ($j = 0; $j < $roundCount; ++$j)
            <td>{{$j + 1}}</td>
            <td>bonus</td>
        @endfor
        <td>Сумма</td>
        <td>Средний</td>
    </tr>
    @foreach($fPlayers as $player)
        <tr class="player">
            <input type="hidden" class="player-id" value="{{$player->id}}">
            <td>{{$player->surname ." ". $player->name}}</td>
            <td class="qualification-result">{{$qResults[$player->id]->sum}}</td>
            @foreach ($fGames[$player->id] as $game)
                <td>
                    <div class="input-group result">
                        <input type="text"
                               class="player-result form-control played"
                               readonly
                               @if(isset($game))
                               value="{{$game->result}}"
                                @endif
                        >
                    </div>
                </td>
                <td>{{$game->bonus}}</td>
            @endforeach
            <td id="sum_result_{{$player->id}}">{{$fResults[$player->id]->sum}}</td>
            <td id="avg_result_{{$player->id}}">{{$fResults[$player->id]->avg}}</td>
        </tr>
    @endforeach
</table>
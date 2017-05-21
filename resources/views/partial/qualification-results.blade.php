<table>
    <tr class="results-header">
        <td>№</td>
        <td>Участник</td>
        @for ($j = 0; $j < $tournament->qualification_entries; ++$j)
            <td>{{$j + 1}}</td>
        @endfor
        <td>Гандикап</td>
        <td>Сумма</td>
        <td>Средний</td>
    </tr>
    @for($i = 0; $i < count($qPlayers); ++$i)
        <tr class="player">
            <input type="hidden" class="player-id" value="{{$qPlayers[$i]->id}}">
            <td>{{$i + 1}}</td>
            <td>{{$qPlayers[$i]->surname ." ". $qPlayers[$i]->name}}</td>
            @foreach ($qGames[$qPlayers[$i]->id] as $game)
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
            @endforeach
            <td id="handicap_{{$qPlayers[$i]->id}}" class="player-bonus">
                @if($qPlayers[$i]->gender == $tournament->handicap->type)
                    {{$tournament->handicap->value}}
                @else
                    {{0}}
                @endif
            </td>
            {{--{{$qResults[$qPlayers[$i]->id]}}--}}
            <td id="sum_result_{{$qPlayers[$i]->id}}">{{$qResults[$qPlayers[$i]->id]->sum}}</td>
            <td id="avg_result_{{$qPlayers[$i]->id}}">{{$qResults[$qPlayers[$i]->id]->avg}}</td>
        </tr>
    @endfor
</table>
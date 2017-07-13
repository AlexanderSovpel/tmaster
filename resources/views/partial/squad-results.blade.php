<table>
  <thead>
    <tr class="results-header">
        <th>№</th>
        <th>Участник</th>
        @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
            <th>{{$j + 1}}</th>
        @endfor
        <th>Г-п</th>
        <th>Сумма</th>
        <th>Средний</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($sPlayers[$squadId]); ++$i)
        <tr class="player">
            <td>{{$i + 1}}</td>
            <input type="hidden" class="player-id" value="{{$sPlayers[$squadId][$i]->id}}">
            <td>{{$sPlayers[$squadId][$i]->surname ." ". $sPlayers[$squadId][$i]->name}}</td>
            @foreach ($sGames[$squadId][$sPlayers[$squadId][$i]->id] as $game)
                <td>
                    @if(isset($game))
                        {{$game->result}}
                    @endif
                </td>
            @endforeach
            <td id="handicap_{{$sPlayers[$squadId][$i]->id}}" class="player-bonus">
                @if($sPlayers[$squadId][$i]->gender == $tournament->handicap->type)
                    {{$tournament->handicap->value}}
                @else
                    {{0}}
                @endif
            </td>
            <td id="sum_result_{{$sPlayers[$squadId][$i]->id}}">{{$sResults[$squadId][$sPlayers[$squadId][$i]->id]->sum}}</td>
            <td id="avg_result_{{$sPlayers[$squadId][$i]->id}}">{{number_format($sResults[$squadId][$sPlayers[$squadId][$i]->id]->avg, 2, ',', ' ')}}</td>
        </tr>
    @endfor
  </tbody>
</table>

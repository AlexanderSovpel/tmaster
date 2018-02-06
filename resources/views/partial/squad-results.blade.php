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
    @foreach($squad->players as $i => $player)
        <tr class="player">
            <td>{{$i + 1}}</td>
            <input type="hidden" class="player-id" value="{{$player->id}}">
            <td>{{$player->surname ." ". $player->name}}</td>
            @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
                <td>
                @if(isset($squad->games[$player->id][$j]))
                {{$squad->games[$player->id][$j]->result}}
                @endif
                </td>
            @endfor
            <td id="handicap_{{$player->id}}" class="player-bonus">
                @if($player->gender == $tournament->handicap->type)
                    {{$tournament->handicap->value}}
                @else
                    {{0}}
                @endif
            </td>
            <td id="sum_result_{{$player}}">{{$squad->results[$player->id]->sum or ''}}</td>
            <td id="avg_result_{{$player}}">{{isset($squad->results[$player->id]) ? number_format($squad->results[$i]->avg, 2, ',', ' ') : ''}}</td>
        </tr>
    @endforeach
  </tbody>
</table>

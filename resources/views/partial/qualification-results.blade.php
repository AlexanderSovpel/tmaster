<table>
  <thead>
    <tr class="results-header">
        <th class="position">№</th>
        <th class="player-name">Участник</th>
        @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
            <th class="player-result">{{$j + 1}}</th>
        @endfor
        <th class="">Г-п</th>
        <th class="player-sum">Сумма</th>
        <th class="player-avg">Средний</th>
    </tr>
  </thead>
  <tbody>
    @foreach($qualification->players as $i => $player)
        <tr class="player">
            <input type="hidden" class="player-id" value="{{$player->id}}">
            <td class="position">
              @if($i < $tournament->qualification->finalists)
              <span class="label label-success">{{$i + 1}}</span>
              @else
              <span class="label label-info">{{$i + 1}}</span>
              @endif
            </td>
            <td class="player-name">{{$player->surname ." ". $player->name}}</td>
            @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
            <td class="player-result">
              @if (isset($qualification->games[$player->id][$j]))
              {{$qualification->games[$player->id][$j]->result}}
              @endif
            </td>
            @endfor
            <td id="handicap_{{$qualification->players[$i]->id}}" class="player-bonus">
                @if($qualification->players[$i]->gender == $tournament->handicap->type)
                    {{$tournament->handicap->value}}
                @else
                    {{0}}
                @endif
            </td>
            <td id="sum_result_{{$qualification->players[$i]->id}}" class="player-sum">{{(isset($qualification->results[$player->id])) ? $qualification->results[$player->id]->sum : ''}}</td>
            <td id="avg_result_{{$qualification->players[$i]->id}}" class="player-avg">{{(isset($qualification->results[$player->id])) ? number_format($qualification->results[$player->id]->avg, 2, ',', ' ') : ''}}</td>
        </tr>
    @endforeach
  </tbody>
</table>

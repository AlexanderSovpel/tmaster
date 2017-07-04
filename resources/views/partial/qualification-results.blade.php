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
    @for($i = 0; $i < count($qPlayers); ++$i)
        <tr class="player">
            <input type="hidden" class="player-id" value="{{$qPlayers[$i]->id}}">
            <td class="position">
              @if($i < $tournament->qualification->finalists)
              <span class="label label-success">{{$i + 1}}</span>
              @else
              <span class="label label-info">{{$i + 1}}</span>
              @endif
            </td>
            <td class="player-name">{{$qPlayers[$i]->surname ." ". $qPlayers[$i]->name}}</td>
            @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
            <td class="player-result">
              @if (isset($qGames[$qPlayers[$i]->id][$j]))
              {{$qGames[$qPlayers[$i]->id][$j]->result}}
              @endif
            </td>
            @endfor
            <td id="handicap_{{$qPlayers[$i]->id}}" class="player-bonus">
                @if($qPlayers[$i]->gender == $tournament->handicap->type)
                    {{$tournament->handicap->value}}
                @else
                    {{0}}
                @endif
            </td>
            <td id="sum_result_{{$qPlayers[$i]->id}}" class="player-sum">{{(isset($qResults[$qPlayers[$i]->id])) ? $qResults[$qPlayers[$i]->id]->sum : ''}}</td>
            <td id="avg_result_{{$qPlayers[$i]->id}}" class="player-avg">{{(isset($qResults[$qPlayers[$i]->id])) ? number_format($qResults[$qPlayers[$i]->id]->avg, 2, ',', ' ') : ''}}</td>
        </tr>
    @endfor
  </tbody>
</table>

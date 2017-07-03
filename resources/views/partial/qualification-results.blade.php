<table class="table">
  <thead>
    <tr class="results-header">
        <th class="position">№</th>
        <th class="player-name">Участник</th>
        @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
            <th class="player-result">{{$j + 1}}</th>
        @endfor
        <th class="player-bonus">Г-п</th>
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
              {{$i + 1}}
              @endif
            </td>
            <td class="player-name">{{$qPlayers[$i]->surname ." ". $qPlayers[$i]->name}}</td>
            @foreach ($qGames[$qPlayers[$i]->id] as $game)
            <td class="player-result">
              @if(isset($game))
              {{$game->result}}
              @endif
            </td>
            @endforeach
            <td id="handicap_{{$qPlayers[$i]->id}}" class="player-bonus">
                @if($qPlayers[$i]->gender == $tournament->handicap->type)
                    {{$tournament->handicap->value}}
                @else
                    {{0}}
                @endif
            </td>
            <td id="sum_result_{{$qPlayers[$i]->id}}" class="player-sum">{{$qResults[$qPlayers[$i]->id]->sum}}</td>
            <td id="avg_result_{{$qPlayers[$i]->id}}" class="player-avg">{{number_format($qResults[$qPlayers[$i]->id]->avg, 2, ',', ' ')}}</td>
        </tr>
    @endfor
  </tbody>
</table>

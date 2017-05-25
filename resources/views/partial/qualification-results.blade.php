<table>
  <thead>
    <tr class="results-header">
        <th class="position">№</th>
        <th class="player-name">Участник</th>
        @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
            <th class="player-result">{{$j + 1}}</th>
        @endfor
        <th class="player-bonus">Гандикап</th>
        <th class="player-sum">Сумма</th>
        <th class="player-avg">Средний</th>
    </tr>
  </thead>
  <tbody>
    @for($i = 0; $i < count($qPlayers); ++$i)
        <tr class="player">
            <input type="hidden" class="player-id" value="{{$qPlayers[$i]->id}}">
            <td class="position">{{$i + 1}}</td>
            <td class="player-name">{{$qPlayers[$i]->surname ." ". $qPlayers[$i]->name}}</td>
            @foreach ($qGames[$qPlayers[$i]->id] as $game)
            <td class="player-result">
              @if(isset($game))
              {{$game->result}}
              @endif
                <!-- <div class="input-group result">
                    <input type="text"
                           class="player-result form-control played"
                           readonly
                           @if(isset($game))
                           value="{{$game->result}}"
                           @endif
                    >
                </div> -->
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
            <td id="sum_result_{{$qPlayers[$i]->id}}" class="player-sum">{{$qResults[$qPlayers[$i]->id]->sum}}</td>
            <td id="avg_result_{{$qPlayers[$i]->id}}" class="player-avg">{{$qResults[$qPlayers[$i]->id]->avg}}</td>
        </tr>
    @endfor
  </tbody>
</table>

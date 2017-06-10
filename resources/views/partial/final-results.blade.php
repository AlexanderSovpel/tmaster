<table class="t">
  <thead>
    <tr class="results-header">
        <th class="position">№</th>
      <th class="player-name">Участник</th>
      <th>Квалификация</th>
      @for ($j = 0; $j < $roundCount; ++$j)
          <th class="player-result">{{$j + 1}}</th>
          <th class="player-bonus"></th>
      @endfor
      <th class="player-sum">Сумма</th>
      <th class="player-avg">Средний</th>
    </tr>
  </thead>
    @foreach($fPlayers as $key => $player)
        <tr class="player">
            <input type="hidden" class="player-id" value="{{$player->id}}">
            <td class="position">{{$key + 1}}</td>
            <td class="player-name">{{$player->surname ." ". $player->name}}</td>
            <td class="qualification-result">{{$qResults[$key]->sum}}</td>
            @foreach ($fGames[$player->id] as $game)
            <td class="player-result">
              @if(isset($game))
              {{$game->result}}
              @endif
            </td>
            <td class="player-bonus">+{{$game->bonus}}</td>
            @endforeach
            <td id="sum_result_{{$player->id}}" class="player-sum">{{$fResults[$key]->sum}}</td>
            <td id="avg_result_{{$player->id}}" class="player-avg">{{$fResults[$key]->avg}}</td>
        </tr>
    @endforeach
</table>

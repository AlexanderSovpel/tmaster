<table>
  <thead>
    <tr class="results-header">
        <th class="position">№</th>
      <th class="player-name">Участник</th>
      <th>Кв-ия</th>
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
            <!-- <td class="qualification-result">{{(isset($qResults[$player->id]->sum)) ? $qResults[$player->id]->sum : $qResults[$player->id]}}</td> -->
            @for ($j = 0; $j < $roundCount; ++$j)
              <td class="player-result">
                {{$fGames[$player->id][$j]->result or ''}}
              </td>
              <td class="player-bonus">+{{$fGames[$player->id][$j]->bonus or ''}}</td>
            @endfor
            <td id="sum_result_{{$player->id}}" class="player-sum">{{$fResults[$player->id]->sum or ''}}</td>
            <td id="avg_result_{{$player->id}}" class="player-avg">{{isset($fResults[$player->id]) ? number_format($fResults[$player->id]->avg, 2, ',', ' ') : ''}}</td>
        </tr>
    @endforeach
</table>

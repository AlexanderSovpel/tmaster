<table>
  <thead>
    <tr class="results-header">
        <th class="position">№</th>
        <th class="player-name">Участник</td>
        <th class="player-sum">Сумма</th>
        <th class="player-avg">Средний</th>
    </tr>
  </thead>
  <tbody>
    @foreach($allResults as $key => $result)
      <tr class="player">
          <td class="position">{{$key + 1}}</td>
        <td class="player-name">{{$result->player->surname ." ". $result->player->name}}</td>
        <td id="sum_result_{{$result->player->id}}" class="player-sum">{{$result->sum}}</td>
        <td id="avg_result_{{$result->player->id}}" class="player-avg">{{$result->avg}}</td>
      </tr>
    @endforeach
  </tbody>
</table>

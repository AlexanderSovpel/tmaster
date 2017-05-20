<table>
    <tr class="results-header">
        <td>Участник</td>
        <td>Сумма</td>
        <td>Средний</td>
    </tr>
    @foreach($allResults as $result)
        <tr class="player">
            <td>{{$result->player->surname ." ". $result->player->name}}</td>
            <td id="sum_result_{{$result->player->id}}">{{$result->sum}}</td>
            <td id="avg_result_{{$result->player->id}}">{{$result->avg}}</td>
        </tr>
    @endforeach
</table>
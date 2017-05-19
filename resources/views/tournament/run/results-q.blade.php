@extends('layouts.run')

@section('process')
<h2>Квалификация - Результаты</h2>
<form action="/{{$tournamentId}}/run/rr/conf/" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="players" value="{{$players}}">
    <table>
        <tr>
            <td>№</td>
            <td>Участник</td>
            @for ($j = 0; $j < $qualificationEntries; ++$j)
                <td>{{$j + 1}}</td>
            @endfor
            <td>Гандикап</td>
            <td>Сумма</td>
            <td>Средний</td>
        </tr>
        @foreach($players as $player)
            <tr class="player">
                <input type="hidden" class="player-id" value="{{$player->id}}">
                <td>{{$i + 1}}</td>
                <td>{{$player->surname ." ". $player->name}}</td>
                @foreach ($playedGames[$player->id] as $game)
                    <td>
                        <div class="input-group result">
                            <input type="text"
                                   class="player-result form-control played"
                                   readonly
                                   @if(isset($game))
                                   value="{{$game}}"
                                    @endif
                            >
                        </div>

                    </td>
                @endforeach
                <td id="handicap_{{$player->id}}" class="player-bonus">
                    {{$game->bonus}}
                </td>
                <td id="sum_result_{{$player->id}}">{{$playersResults[$player->id]->sum}}</td>
                <td id="avg_result_{{$player->id}}">{{$playersResults[$player->id]->avg}}</td>
            </tr>
        @endforeach
    </table>
    <button type="submit">начать финал</button>
</form>
@endsection

@extends('layouts.run')

@section('process')
<h2>Квалификация - Результаты</h2>
<form action="/{{$tournament->id}}/run/rr/conf/" method="get">
    {{ csrf_field() }}
    <input type="hidden" name="players" value="{{json_encode($players)}}">
    <table>
        <tr>
            <td>№</td>
            <td>Участник</td>
            @for ($j = 0; $j < $tournament->qualification_entries; ++$j)
                <td>{{$j + 1}}</td>
            @endfor
            <td>Гандикап</td>
            <td>Сумма</td>
            <td>Средний</td>
        </tr>
        @for($i = 0; $i < count($players); ++$i)
            <tr class="player">
                <input type="hidden" class="player-id" value="{{$players[$i]->id}}">
                <td>{{$i + 1}}</td>
                <td>{{$players[$i]->surname ." ". $players[$i]->name}}</td>
                @foreach ($playedGames[$players[$i]->id] as $game)
                    <td>
                        <div class="input-group result">
                            <input type="text"
                                   class="player-result form-control played"
                                   readonly
                                   @if(isset($game))
                                   value="{{$game->result}}"
                                    @endif
                            >
                        </div>

                    </td>
                @endforeach
                <td id="handicap_{{$players[$i]->id}}" class="player-bonus">
                    @if($players[$i]->gender == $tournament->handicap_type)
                        {{$tournament->handicap_value}}
                    @else
                        {{0}}
                    @endif
                </td>
                {{--{{$playersResults[$players[$i]->id]}}--}}
                <td id="sum_result_{{$players[$i]->id}}">{{$playersResults[$players[$i]->id]->sum}}</td>
                <td id="avg_result_{{$players[$i]->id}}">{{$playersResults[$players[$i]->id]->avg}}</td>
            </tr>
        @endfor
    </table>
    <button type="submit">начать финал</button>
</form>
@endsection

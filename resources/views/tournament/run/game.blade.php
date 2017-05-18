@extends('layouts.run')

@section('process')
    <h2>Игра</h2>
    {{--<form action="/{{$tournament->id}}/run/{{$part}}/rest/{{$currentSquad->id}}?squadFinished=1" method="post">--}}
    <form action="/{{$tournament->id}}/run/{{$part}}/rest" method="post">
        {{ csrf_field() }}
        <table>
            <tr>
                <td>№</td>
                <td>Участник</td>
                @for ($j = 1; $j <= 6; ++$j)
                    <td>{{$j}}</td>
                @endfor
                <td>Гандикап</td>
                <td>Сумма</td>
                <td>Средний</td>
            </tr>
            @for($i = 0; $i < count($players); ++$i)
                <tr>
                    <td>{{$i + 1}}</td>
                    <td>{{$players[$i]->surname ." ". $players[$i]->name}}</td>
                    @for ($j = 0; $j < $tournament->qualification_entries; ++$j)
                        <td><input type="text"
                                   class="game_result"
                                   name="result_{{$players[$i]->id
                    ."_".$tournament->id
                    ."_".$part
                    ."_".$currentSquadId}}[]"
                                   @if(isset($playedGames[$players[$i]->id][$j]))
                                   value="{{$playedGames[$players[$i]->id][$j]->result}}"
                                   @endif
                                   onfocus="this.old_value = this.value">
                        </td>
                    @endfor
                    <td id="handicap_{{$players[$i]->id}}">
                        @if($players[$i]->gender == $tournament->handicap_type)
                            {{$tournament->handicap_value}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td id="sum_result_{{$players[$i]->id}}"></td>
                    <td id="avg_result_{{$players[$i]->id}}"></td>
                    {{--<td><input type="text" name="position{{$player->id}}" value=""></td>--}}
                </tr>
            @endfor
        </table>
        <button type="submit">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
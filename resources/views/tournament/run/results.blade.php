@extends('layouts.run')

@section('process')
    <h2>Результаты</h2>
    @if($tournament->squads[$tournament->squads()->count() - 1]->id == $currentSquad->id)
        <form action="/{{$tournament->id}}/run/q" method="get">
            @else
                <form action="/{{$tournament->id}}/run/{{$part}}/conf/{{$currentSquad->id + 1}}?squadFinished=0"
                      method="post">
                    @endif
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
                        @for($i = 0; $i < count($currentSquad->players); ++$i)
                            <tr>
                                <td>{{$i + 1}}</td>
                                <td>{{$currentSquad->players[$i]->surname ." ". $currentSquad->players[$i]->name}}</td>
                                @for ($j = 0; $j < $tournament->qualification_entries; ++$j)
                                    {{--                        {{$currentSquad->players[$i]->id}}--}}
                                    <td>
                                        <input type="text" readonly class="game_result"
                                               name="result_{{$currentSquad->players[$i]->id
                                    ."_".$tournament->id
                                    ."_".$part
                                    ."_".$currentSquad->id}}[]"
                                               @if(isset($playedGames[$currentSquad->players[$i]->id][$j]))
                                               value="{{$playedGames[$currentSquad->players[$i]->id][$j]->result}}"
                                                @endif
                                        >
                                    </td>
                                @endfor
                                <td id="handicap_{{$currentSquad->players[$i]->id}}">
                                    @if($currentSquad->players[$i]->gender == $tournament->handicap_type)
                                        {{$tournament->handicap_value}}
                                    @else
                                        {{0}}
                                    @endif
                                </td>
                                <td id="sum_result_{{$currentSquad->players[$i]->id}}"></td>
                                <td id="avg_result_{{$currentSquad->players[$i]->id}}"></td>
                                {{--<td><input type="text" name="position{{$player->id}}" value=""></td>--}}
                            </tr>
                        @endfor
                    </table>
                    <button type="submit">завершить игру</button>
                    <div id="error"></div>
                </form>
@endsection
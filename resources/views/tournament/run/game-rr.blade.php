@extends('layouts.run')

@section('process')
    <h2>Игра</h2>
    <form action="/{{$tournament->id}}/run/{{$part}}/rest" method="post">
        {{ csrf_field() }}

        @for($i = 0; $i < $roundCount; ++$i)
            <div class="round">
                <h3>Round {{$i+1}}</h3>
                @for($j = 0, $h = $lastPlayerIndex; $j < ($lastPlayerIndex + 1) / 2; ++$j, --$h)
                    <div class="opponents">
                        <div class="input-group opponent">
                            <input type="hidden" class="opponent-id input-group-addon" value="{{$players[$j]->id}}">
                            <label for="opponent-{{$players[$j]->id}}" class="input-group-addon opponent-name">
                                {{$players[$j]->surname.' '.$players[$j]->name}}
                            </label>
                            <input type="text"
                                   id="opponent-{{$players[$j]->id}}"
                                   class="form-control opponent-result"
                                   onfocus="this.old_value = this.value">
                            <span class="opponent-bonus input-group-addon"></span>
                            <span class="input-group-btn">
                                <button class="btn btn-secondary post-opponent-result" type="button">set</button>
                            </span>
                        </div>
                        <div class="input-group opponent">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary post-opponent-result" type="button">set</button>
                            </span>
                            <span class="opponent-bonus input-group-addon">

                            </span>
                            <input type="text"
                                   id="opponent-{{$players[$h]->id}}"
                                   class="form-control opponent-result"
                                   onfocus="this.old_value = this.value">
                            <label for="opponent-{{$players[$h]->id}}" class="input-group-addon opponent-name">
                                {{$players[$h]->surname.' '.$players[$h]->name}}
                            </label>
                            <input type="hidden" class="opponent-id input-group-addon" value="{{$players[$h]->id}}">
                        </div>
                    </div>
                @endfor
            </div>
            @php
                array_unshift($players, array_pop($players));
                $temp = $players[0];
                $players[0] = $players[$lastPlayerIndex];
                $players[$lastPlayerIndex] = $temp;
            @endphp
        @endfor

        {{--<table>--}}
        {{--<tr>--}}
        {{--<td></td>--}}
        {{--<td>№</td>--}}
        {{--<td>Участник</td>--}}
        {{--@for ($j = 0; $j < $tournament->qualification_entries - 1; ++$j)--}}
        {{--<td>{{$j + 1}}</td>--}}
        {{--<td>Bonus</td>--}}
        {{--@endfor--}}
        {{--<td>Сумма</td>--}}
        {{--<td>Средний</td>--}}
        {{--</tr>--}}
        {{--@for($i = 0; $i < count($players); ++$i)--}}
        {{--<tr class="player">--}}
        {{--<td><input type="hidden" class="playerId" value="{{$players[$i]->id}}"></td>--}}
        {{--<td>{{$i + 1}}</td>--}}
        {{--<td>{{$players[$i]->surname ." ". $players[$i]->name}}</td>--}}
        {{--@for ($j = 0; $j < $tournament->qualification_entries - 1; ++$j)--}}
        {{--<td><input type="text"--}}
        {{--readonly--}}
        {{--class="game_result"--}}
        {{--name="result[]"--}}
        {{--value="{{isset($playedGames[$players[$i]->id][$j]) ? $playedGames[$players[$i]->id][$j]->result : ''}}"--}}
        {{--onfocus="this.old_value = this.value">--}}
        {{--</td>--}}
        {{--<td class="bonus"></td>--}}
        {{--@endfor--}}
        {{--<td id="sum_result_{{$players[$i]->id}}"></td>--}}
        {{--<td id="avg_result_{{$players[$i]->id}}"></td>--}}
        {{--</tr>--}}
        {{--@endfor--}}
        {{--</table>--}}

        <button type="submit">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
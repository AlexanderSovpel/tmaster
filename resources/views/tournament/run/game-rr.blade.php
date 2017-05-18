@extends('layouts.run')

@section('process')
    <h2>Игра</h2>
    <form action="/{{$tournament->id}}/run/{{$part}}/rest" method="post">
        {{ csrf_field() }}

        @for($i = 0; $i < $roundCount; ++$i)
            <h3>Round {{$i+1}}</h3>
            @for($j = 0, $h = $lastPlayerIndex; $j < ($lastPlayerIndex + 1) / 2; ++$j, --$h)
                <p>{{$players[$j]->surname.' - '.$players[$h]->surname}}</p>
            @endfor
            @php
                array_unshift($players, array_pop($players));
                $temp = $players[0];
                $players[0] = $players[$lastPlayerIndex];
                $players[$lastPlayerIndex] = $temp;
            @endphp
        @endfor

        <table>
            <tr>
                <td>№</td>
                <td>Участник</td>
                @for ($j = 1; $j <= 6; ++$j)
                    <td>{{$j}}</td>
                    <td>Bonus</td>
                @endfor
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
                    ."_".$part}}[]"
                                   @if(isset($playedGames[$players[$i]->id][$j]))
                                   value="{{$playedGames[$players[$i]->id][$j]->result}}"
                                   @endif
                                   onfocus="this.old_value = this.value">
                        </td>
                        <td></td>
                    @endfor
                    <td id="sum_result_{{$players[$i]->id}}"></td>
                    <td id="avg_result_{{$players[$i]->id}}"></td>
                </tr>
            @endfor
        </table>

        <button type="submit">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
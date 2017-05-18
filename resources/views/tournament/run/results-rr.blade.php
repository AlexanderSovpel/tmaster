@extends('layouts.run')

@section('process')
    <h2>Результаты</h2>
    <form action="/{{$tournament->id}}/run/{{$part}}" method="get">
        {{ csrf_field() }}
        <table>
            <tr>
                <td>№</td>
                <td>Участник</td>
                @for ($j = 0; $j < $roundCount; ++$j)
                    <td>{{$j + 1}}</td>
                    <td>bonus</td>
                @endfor
                <td>Сумма</td>
                <td>Средний</td>
            </tr>
            @for($i = 0; $i < count($players); ++$i)
                <tr>
                    <td>{{$i + 1}}</td>
                    <td>{{$players[$i]->surname ." ". $players[$i]->name}}</td>
                    @foreach ($playedGames[$players[$i]->id] as $game)
                        <td>
                            <input type="text" readonly class="game_result"
                                   name="result_{{$players[$i]->id}}"
                                   @if(isset($game))
                                   value="{{$game->result}}"
                                    @endif
                            >
                        </td>
                        <td>{{$game->bonus}}</td>
                        @endforeach
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
@extends('layouts.run')

@section('process')
    <h2>Результаты</h2>
    <form action="/{{$tournament->id}}/results" method="get">
        {{ csrf_field() }}
        <table>
            <tr>
                <td>Участник</td>
                <td>Квалификация</td>
                @for ($j = 0; $j < $roundCount; ++$j)
                    <td>{{$j + 1}}</td>
                    <td>bonus</td>
                @endfor
                <td>Сумма</td>
                <td>Средний</td>
            </tr>
            @foreach($players as $player)
                <tr class="player">
                    <input type="hidden" class="player-id" value="{{$player->id}}">
                    <td>{{$player->surname ." ". $player->name}}</td>
                    <td class="qualification-result">{{$qualificationResults[$player->id]->sum}}</td>
                    @foreach ($playedGames[$player->id] as $game)
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
                        <td>{{$game->bonus}}</td>
                    @endforeach
                    <td id="sum_result_{{$player->id}}">{{$playersResults[$player->id]->sum}}</td>
                    <td id="avg_result_{{$player->id}}">{{$playersResults[$player->id]->avg}}</td>
                </tr>
            @endforeach
        </table>
        <button type="submit">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
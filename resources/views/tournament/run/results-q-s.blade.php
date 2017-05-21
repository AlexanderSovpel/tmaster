@extends('layouts.run')

@section('process')
    <h2>Результаты</h2>
    <form action="/{{$tournament->id}}/run/q/conf/{{$currentSquadId}}" method="get">
        {{ csrf_field() }}
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
                    <td>{{$i + 1}}</td>
                    <input type="hidden" class="player-id" value="{{$players[$i]->id}}">
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
                        @if($players[$i]->gender == $tournament->handicap->type)
                            {{$tournament->handicap->value}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td id="sum_result_{{$players[$i]->id}}">{{$playersResults[$players[$i]->id]->sum}}</td>
                    <td id="avg_result_{{$players[$i]->id}}">{{$playersResults[$players[$i]->id]->avg}}</td>
                </tr>
            @endfor
        </table>
        <button type="submit">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
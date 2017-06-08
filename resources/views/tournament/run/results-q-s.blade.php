@extends('layouts.run')

@section('process')
    <h1>Результаты</h1>
    <form action="/{{$tournament->id}}/run/q/conf/{{$currentSquadId}}" method="get">
        {{ csrf_field() }}
        <table>
            <thead>
            <tr class="results-header">
                <th>№</th>
                <th>Участник</th>
                @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
                    <th>{{$j + 1}}</th>
                @endfor
                <th>Гандикап</th>
                <th>Сумма</th>
                <th>Средний</th>
            </tr>
            </thead>
            <tbody>
            @for($i = 0; $i < count($players); ++$i)
                <tr class="player">
                    <td>{{$i + 1}}</td>
                    <input type="hidden" class="player-id" value="{{$players[$i]->id}}">
                    <td>{{$players[$i]->surname ." ". $players[$i]->name}}</td>
                    @foreach ($playedGames[$players[$i]->id] as $game)
                        <td>
                            @if(isset($game))
                                {{$game->result}}
                            @endif
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
            </tbody>
        </table>
        <button type="submit btn">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
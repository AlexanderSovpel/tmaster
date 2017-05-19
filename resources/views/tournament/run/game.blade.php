@extends('layouts.run')

@section('process')
    <h2>Игра</h2>
    <form action="/{{$tournamentId}}/run/q/rest/{{$currentSquadId}}" method="get">
        {{ csrf_field() }}
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
            @for($i = 0; $i < count($players); ++$i)
                <tr class="player">
                    <input type="hidden" class="player-id" value="{{$players[$i]->id}}">
                    <td>{{$i + 1}}</td>
                    <td>{{$players[$i]->surname ." ". $players[$i]->name}}</td>
                    @for ($j = 0; $j < $qualificationEntries; ++$j)
                        <td>
                            <div class="input-group result">
                                <input type="text"
                                       @if(isset($playedGames[$players[$i]->id][$j]))
                                       value="{{$playedGames[$players[$i]->id][$j]->result}}"
                                       old_value="{{$playedGames[$players[$i]->id][$j]->result}}"
                                       class="player-result form-control played"
                                       @else
                                       class="player-result form-control"
                                       @endif
                                       onfocus="this.old_value = this.value">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary post-result" type="button">set</button>
                                </span>
                            </div>

                        </td>
                    @endfor
                    <td id="handicap_{{$players[$i]->id}}" class="player-bonus">
                        @if($players[$i]->gender == $tournament->handicap_type)
                            {{$tournament->handicap_value}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td id="sum_result_{{$players[$i]->id}}"></td>
                    <td id="avg_result_{{$players[$i]->id}}"></td>
                </tr>
            @endfor
        </table>
        <button type="submit">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
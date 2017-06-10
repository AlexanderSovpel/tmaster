@extends('layouts.run')

@section('process')
    <div class="panel-heading"><h1>Игра</h1></div>
    <form action="/{{$tournament->id}}/run/q/rest/{{$currentSquadId}}" method="post" class="panel-body">
        {{ csrf_field() }}
        <input type="hidden" name="players" value="{{$players}}">
        <table>
          <thead>
            <tr>
                <th>№</th>
                <th>Участник</th>
                @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
                    <th>{{$j + 1}}</th>
                @endfor
                <th>Г-п</th>
                <th>Сум.</th>
                <th>Ср.</th>
            </tr>
          </thead>
            @for($i = 0; $i < count($players); ++$i)
                <tr class="player">
                    <input type="hidden" class="player-id" value="{{$players[$i]->id}}">
                    <td>{{$i + 1}}</td>
                    <td>{{$players[$i]->surname ." ". $players[$i]->name}}</td>
                    @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
                        {{--                    @foreach ($j = 0; $j < $tournament->qualification->entries; ++$j)--}}
                        <td>
                            <div class="input-group result">
                                <input type="text"
                                       @if(isset($playedGames[$players[$i]->id][$j]))
                                       value="{{$playedGames[$players[$i]->id][$j]->result}}"
                                       old_value="{{$playedGames[$players[$i]->id][$j]->result}}"
                                       class="player-result form-control played input"
                                       @else
                                       class="player-result form-control input"
                                       @endif
                                       onfocus="this.old_value = this.value">
                                <span class="input-group-btn">
                                    <button class="post-result btn" type="button">
                                      <span class="glyphicon glyphicon-ok"></span>
                                    </button>
                                </span>
                            </div>

                        </td>
                    @endfor
                    {{--@endforeach--}}
                    <td id="handicap_{{$players[$i]->id}}" class="player-bonus">
                        @if($players[$i]->gender == $tournament->handicap->type)
                            {{$tournament->handicap->value}}
                        @else
                            {{0}}
                        @endif
                    </td>
                    <td id="sum_result_{{$players[$i]->id}}"></td>
                    <td id="avg_result_{{$players[$i]->id}}"></td>
                </tr>
            @endfor
        </table>
        <button type="submit" class="btn">завершить игру</button>
        {{--<div id="error"></div>--}}
    </form>
@endsection

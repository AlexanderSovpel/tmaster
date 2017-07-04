@extends('layouts.run')

@section('process')
<article class="panel panel-default part">
    <div class="panel-heading"><h1>Результаты потока</h1></div>
    <form action="/{{$tournament->id}}/run/q/conf/{{$currentSquadId}}" method="get" class="panel-body">
        {{ csrf_field() }}
        <table>
          <thead>
            <tr class="results-header">
                <th>№</th>
                <th>Участник</th>
                @for ($j = 0; $j < $tournament->qualification->entries; ++$j)
                    <th>{{$j + 1}}</th>
                @endfor
                <th>Г-п</th>
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
                    <td id="avg_result_{{$players[$i]->id}}">{{number_format($playersResults[$players[$i]->id]->avg, 2, ',', ' ')}}</td>
                </tr>
            @endfor
          </tbody>
        </table>
        <button type="submit" class="btn">завершить поток</button>
        <div id="error"></div>
    </form>
  </article>
@endsection

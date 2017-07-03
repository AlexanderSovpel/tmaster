@extends('layouts.run')

@section('process')
    <div class="panel-heading"><h1>Жеребьёвка</h1></div>
    <form action="/{{$tournament->id}}/run/{{$part}}/game/{{$currentSquadId or ''}}" method="get" class="panel-body">
        {{ csrf_field() }}
        <table>
          <thead>
            <tr>
                <th>Участник</th>
                <th>Дорожка</th>
                <th>Позиция</th>
            </tr>
          </thead>
          <tbody>
            @foreach($players as $player)
                <tr>
                    <td>{{"$player->surname $player->name"}}</td>
                    <td><input type="text" name="lane_{{$player->id}}" class="form-control input" value=""></td>
                    <td><input type="text" name="position_{{$player->id}}" class="form-control input" value=""></td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <button type="submit" class="btn">начать игру</button>
    </form>
@endsection

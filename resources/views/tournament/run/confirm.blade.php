@extends('layouts.run')

@section('process')
    <div class="panel-heading"><h1>Регистрация участников</h1></div>
    <form action="/{{$tournament->id}}/run/{{$part}}/draw/{{$currentSquadId or ''}}" method="get" class="panel-body">
        {{ csrf_field() }}
        <!-- <input type="hidden" name="players" value="{{json_encode($players)}}"> -->
        <table>
          <thead>
            <tr>
                <th>Участник</th>
                <th>Подтверждение</th>
            </tr>
          </thead>
          <tbody>
            @foreach($players as $player)
                <tr>
                    <td>{{"$player->surname $player->name"}}</td>
                    <td>
                        <input type="checkbox" name="confirmed[]" value="{{$player->id}}" class="confirm-checkbox"
                               id="player_{{$player->id}}">
                        <label for="player_{{$player->id}}"> </label>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <button type="submit" class="btn">начать жеребьёвку</button>
    </form>
@endsection

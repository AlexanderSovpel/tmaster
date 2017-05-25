@extends('layouts.run')

@section('process')
    <h1>Регистрация участников</h1>
    <form action="/{{$tournament->id}}/run/{{$part}}/draw/{{$currentSquadId or ''}}" method="get">
        {{ csrf_field() }}
        <input type="hidden" name="players" value="{{json_encode($players)}}">
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
                    <td><input type="checkbox" name="confirmed[]" value="{{$player->id}}"></td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <button type="submit">начать жеребьёвку</button>
    </form>
@endsection

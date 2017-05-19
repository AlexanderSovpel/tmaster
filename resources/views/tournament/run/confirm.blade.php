@extends('layouts.run')

@section('process')
    <h2>Регистрация участников</h2>
    <form action="/{{$tournament->id}}/run/{{$part}}/draw/{{$currentSquadId or ''}}" method="get">
        {{ csrf_field() }}
        <input type="hidden" name="players" value="{{json_encode($players)}}">
        <table>
            <tr>
                <td>Участник</td>
                <td>Подтверждение</td>
            </tr>
            @foreach($players as $player)
                <tr>
                    <td>{{"$player->surname, $player->name"}}</td>
                    <td><input type="checkbox" name="confirmed[]" value="{{$player->id}}"></td>
                </tr>
            @endforeach
        </table>
        <button type="submit">начать жеребьёвку</button>
    </form>
@endsection
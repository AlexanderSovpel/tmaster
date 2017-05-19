@extends('layouts.run')

@section('process')
    <h2>Жеребьёвка</h2>
    <form action="/{{$tournament->id}}/run/{{$part}}/game/{{$currentSquadId or ''}}" method="get">
        {{ csrf_field() }}
        <input type="hidden" name="players" value="{{json_encode($players)}}">
        <table>
            <tr>
                <td>Участник</td>
                <td>Дорожка</td>
                <td>Позиция</td>
            </tr>
            @foreach($players as $player)
                <tr>
                    <td>{{"$player->surname $player->name"}}</td>
                    <td><input type="text" name="lane{{$player->id}}" value=""></td>
                    <td><input type="text" name="position{{$player->id}}" value=""></td>
                </tr>
            @endforeach
        </table>
        <button type="submit">начать игру</button>
    </form>
@endsection
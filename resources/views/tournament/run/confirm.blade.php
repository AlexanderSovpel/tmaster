@extends('layouts.run')

@section('process')
    <h2>Регистрация участников</h2>
    @if(isset($currentSquadId))
        <form action="/{{$tournament->id}}/run/{{$part}}/draw/{{$currentSquadId}}?squadFinished={{$squadFinished}}"
              method="post">
            @else
    <form action="/{{$tournament->id}}/run/{{$part}}/draw" method="post">
        @endif
        {{ csrf_field() }}
        <table>
            <tr>
                <td>Участник</td>
                <td>Подтверждение</td>
            </tr>
            {{--        @foreach($currentSquad->players as $player)--}}
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
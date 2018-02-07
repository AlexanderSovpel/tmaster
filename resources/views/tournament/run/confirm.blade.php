@extends('layouts.run')

@section('process')
  <article class="panel panel-default part">
    <div class="panel-heading"><h1>Регистрация участников</h1></div>
    <form action="/{{$tournament->id}}/run/{{$part}}/draw{{isset($currentSquadId) ? '/'.$currentSquadId : ''}}" method="post" class="panel-body">
        {{ csrf_field() }}
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
        @if (isset($currentSquad) && $currentSquad->players()->count() < $currentSquad->max_players)
          <a href="#" class="no-application-player-btn pull-right">добавить участника</a>
        @endif
        <button type="submit" class="btn">начать жеребьёвку</button>
    </form>
  </article>
@endsection

@extends('layouts.run')

@section('process')
<article class="panel panel-default part">
    <div class="panel-heading"><h1>Жеребьёвка</h1></div>
    <form action="/{{$tournament->id}}/run/{{$part}}/game{{isset($currentSquadId) ? '/'.$currentSquadId : ''}}" method="post" class="panel-body">
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
            @foreach($players()->orderBy('surname', 'ASC')->get() as $player)
                <tr>
                    <td>{{"$player->surname $player->name"}}</td>
                    <td><input type="text" name="lane[]" class="form-control input" value=""></td>
                    <td><input type="text" name="position[]" class="form-control input" value=""></td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <button type="submit" class="btn">начать игру</button>
    </form>
  </article>
@endsection

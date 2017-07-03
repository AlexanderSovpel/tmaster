@extends('layouts.app')

@section('content')
  <article class="panel panel-default">
    <div class="panel-header">
      <h1>Рейтинг игроков</h1>
    </div>
    <div class="panel-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>№</th>
            <th>ID</th>
            <th>Игрок</th>
            <th>Судья</th>
            <th>Сумма</th>
            <!-- <th>Средний</th> -->
          </tr>
        </thead>
        <tbody>
        @foreach($players as $index => $player)
          <tr>
            <td>{{$index + 1}}</td>
            <td>{{$player->id}}</td>
            <td>{{$player->name}} {{$player->surname}}</td>
            <td>
                @if($player->is_admin)
                <span class="label label-success">
                  <span class="glyphicon glyphicon-ok"></span>
                </span>
                @else
                <span class="label label-danger">
                  <span class="glyphicon glyphicon-remove"></span>
                </span>
                @endif
            </td>
            <td>{{$player->resultsSum}}</td>
            <!-- <td>{{$player->results()->where('part', 'rr')->avg('avg')}}</td> -->
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </article>
@endsection

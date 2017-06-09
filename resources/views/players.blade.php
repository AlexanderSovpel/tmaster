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
            <th>Сумма</th>
            <th>Средний</th>
          </tr>
        </thead>
        <tbody>
        {{-- @foreach($players as $index => $player)
          <tr class="">
            <td>{{$index}}</td>
            <td>{{$player->id}}</td>
            <td>{{$player->name}} {{$player->surname}}</td>
            <td>{{$player->results()->where('part', 'rr')->sum('sum')}}</td>
            <td>{{$player->results()->where('part', 'rr')->avg('avg')}}</td>
          </tr>
        @endforeach --}}
        </tbody>
      </table>
    </div>
  </article>
@endsection

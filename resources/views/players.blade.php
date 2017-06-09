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
        </tbody>
      </table>
    </div>
  </article>
@endsection

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
            <th>Судья</th>
          </tr>
        </thead>
        <tbody>
        @foreach($players as $index => $player)
          <tr class="player-info">
            <td>{{$index + 1}}</td>
            <td>{{$player->id}}</td>
            <td><a href="/{{$player->id}}/account">{{$player->name}} {{$player->surname}}</a></td>
            <td>{{$player->resultsSum}}</td>
            <td>
              @if($player->is_admin)
                @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                  <button type="button" data-toggle="modal" data-target="#toggleAdmin" data-id="{{$player->id}}" data-player="{{$player->name}} {{$player->surname}}">
                    <span class="label label-success">
                      <span class="glyphicon glyphicon-ok"></span>
                    </span>
                  </button>
                @else
                  <span class="label label-success">
                    <span class="glyphicon glyphicon-ok"></span>
                  </span>
                @endif
              @else
                @if(Auth::user()->is_admin)
                  <button type="button" data-toggle="modal" data-target="#toggleAdmin" data-id="{{$player->id}}" data-player="{{$player->name}} {{$player->surname}}">
                    <span class="label label-danger">
                      <span class="glyphicon glyphicon-remove"></span>
                    </span>
                  </button>
                @else
                  <span class="label label-danger">
                    <span class="glyphicon glyphicon-remove"></span>
                  </span>
                @endif
              @endif
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </article>

  <!-- Modal -->
  <div class="modal fade" id="toggleAdmin" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Изменение статуса</h4>
        </div>
        <div class="modal-body">
          <p>Вы действительно хотите изменить статус игрока?</p>
        </div>
        <div class="modal-footer">
          <p id="player"></p>
          <button type="button" class="btn cancel-btn" data-dismiss="modal">Отменить</button>
          <button type="submit" class="btn" data-dismiss="modal" id="toggle-admin">Изменить</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script src="{{ asset('js/players.js') }}"></script>
@endsection

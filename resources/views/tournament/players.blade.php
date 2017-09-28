@extends('layouts.app')
@section('content')
    <input type="hidden" name="tournament_id" id="tournament-id" value="{{$tournament->id}}">
    @include('partial.breadcrumb', ['page' => 'Заявки'])
    <div class="squads">
    @foreach($tournament->squads()->orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->get() as $index => $squad)
        <article class="squad panel panel-default">
            <div class="panel-heading"><h1>Поток {{$index + 1}}</h1></div>
            <div class="panel-body">
                <input type="hidden" value="{{$squad->id}}" name="squad_id">
                <p class="date">{{date('j.m.Y', strtotime($squad->date))}}, {{date('H:i', strtotime($squad->start_time))}} &ndash; {{date('H:i', strtotime($squad->end_time))}}</p>
                <p class="players-label">Заявки:</p>
                <ol class="players-list">
                  @php
                    $squadPlayers = SquadPlayers::where('squad_id', $squad->id)->get();
                  @endphp
                    @foreach($squad->players as $playerIndex => $player)
                      <li>{{$player->surname}} {{$player->name}}</li>
                      @if ($squad->finished && $squadPlayers[$playerIndex]->present)
                      <span class="glyphicon glyphicon-ok"></span>
                      @endif
                      @if (\Illuminate\Support\Facades\Auth::check() && !$tournament->finished)
                        @if ($player->id == \Illuminate\Support\Facades\Auth::id())
                          <form action="/{{$tournament->id}}/removeApplication/{{$player->id}}" method="post">
                              {{ csrf_field() }}
                              <input type="hidden" name="currentSquad" value="{{$squad->id}}">
                              <button type="submit" class="remove-btn btn-link">Отозвать заявку</button>
                          </form>
                        @elseif(\Illuminate\Support\Facades\Auth::user()->is_admin && !$tournament->finished)
                          <form action="/{{$tournament->id}}/removeApplication/{{$player->id}}" method="post">
                              {{ csrf_field() }}
                              <input type="hidden" name="currentSquad" value="{{$squad->id}}">
                              <button type="submit" class="remove-btn btn-link">Удалить</button>
                          </form>
                        @endif
                      @endif
                    @endforeach
                </ol>
                <div class="clearfix"></div>
                @if(\Illuminate\Support\Facades\Auth::check() && $squad->players()->count() < $squad->max_players && !$tournament->finished)
                  @if(!\Illuminate\Support\Facades\Auth::user()->is_admin)
                    <form method="post" action="/{{$tournament->id}}/sendApplication" class="apply-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="squad" value="{{$squad->id}}">
                        <button type="submit" class="btn tournament-btn players-tournament-btn">подать заявку
                        </button>
                    </form>
                  @else
                    <a href="#" class="btn add-player-btn">добавить участника</a>
                  @endif
                @endif
            </div>
      </article>
    @endforeach
    </div>
    <div class="clearfix"></div>
    <div class="error"></div>
@endsection

@extends('layouts.app')
@section('content')
    <input type="hidden" name="tournament_id" id="tournament-id" value="{{$tournament->id}}">
    @include('partial.breadcrumb', ['page' => 'Участники'])
    <div class="squads">
    @foreach($tournament->squads()->orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->get() as $index => $squad)
        <article class="squad panel panel-default">
            <div class="panel-heading"><h1>Поток {{$index + 1}}</h1></div>
            <div class="panel-body">
                <input type="hidden" value="{{$squad->id}}" name="squad_id">
                <p class="date">{{date('j.m.Y', strtotime($squad->date))}}, {{date('H:i', strtotime($squad->start_time))}} &ndash; {{date('H:i', strtotime($squad->end_time))}}</p>
                <p class="players-label">Участники:</p>
                <ol class="players-list">
                    @foreach($squad->players as $player)
                        <li>{{$player->surname}} {{$player->name}}</li>
                        @if ($player->id == \Illuminate\Support\Facades\Auth::id() && !$tournament->finished)
                            <form action='{{url("$tournament->id/removeApplication")}}' method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="currentSquad" value="{{$squad->id}}">
                                <button type="submit" class="remove-btn btn-link">Отозвать заявку</button>
                            </form>
                        @endif
                    @endforeach
                </ol>
                <div class="clearfix"></div>
                @if($squad->players()->count() < $squad->max_players && !$tournament->finished)
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

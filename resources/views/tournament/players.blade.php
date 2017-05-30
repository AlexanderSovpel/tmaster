@extends('layouts.app')
@section('content')
    @include('partial.breadcrumb', ['page' => 'Участники'])
    @foreach($tournament->squads as $index => $squad)
        <article class="squad panel panel-default">
            <div class="panel-heading"><h1>Поток {{$index + 1}}</h1></div>
            <div class="panel-body">
        <p class="date">{{$squad->date}}, {{$squad->start_time}} &ndash; {{$squad->end_time}}</p>
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
            </div>
      </article>
    @endforeach
@endsection

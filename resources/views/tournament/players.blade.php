@extends('layouts.app')
@section('content')
    <div class="container">
        @foreach($tournament->squads as $squad)
            <ul>
                <h1>{{$squad->id}}</h1>
                <p>{{$squad->date}}, {{$squad->start_time}}-{{$squad->end_time}}</p>
                <ul>
                    @foreach($squad->players as $player)
                        <li>{{$player->surname}} {{$player->name}} ({{$player->gender}}), {{$player->birthday}}
                            @if ($player->id == \Illuminate\Support\Facades\Auth::id())
                                <form action="{{url("$tournament->id/removeApplication")}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="player" value="{{$player->id}}">
                                    <input type="hidden" name="currentSquad" value="{{$squad->id}}">
                                    <button type="submit" id="removeButton">REMOVE</button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </ul>
        @endforeach
    </div>
@endsection
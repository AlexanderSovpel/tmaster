@extends('layouts.app')

@section('content')
    <div class="container">
        @if($user->is_admin)
            <a href="/newTournament">new tournament</a>
        @endif
        @foreach($tournaments as $tournament)
            <h1>{{ $tournament->name }}</h1>
            <input type="hidden" value="{{$tournament->id}}">
            <ul>
                <li>Type: {{ $tournament->type }}</li>
                <li>Location: {{ $tournament->location }}</li>
                <li>Oil type: {{ $tournament->oil_type }}</li>
                <li>Description: {{ $tournament->description }}</li>
                <li>Handicap: {{ $tournament->handicap->type }}, {{$tournament->handicap->value}}</li>
                <li>Squads:
                    <ul>
                        @foreach($tournament->squads as $squad)
                            <li>{{$squad->date}}, {{$squad->start_time}}-{{$squad->end_time}}</li>
                        @endforeach
                    </ul>
                </li>
                <li>Round Robin: {{$tournament->roundRobin->date}}, {{$tournament->roundRobin->start_time}}
                    -{{$tournament->roundRobin->end_time}}</li>
                <li>Contact: {{$tournament->contact->surname}} {{$tournament->contact->name}},
                    {{$tournament->contact->phone}},
                    {{$tournament->contact->email}}</li>
            </ul>
            <a href="/{{$tournament->id}}/players">players</a>
            @if(\Illuminate\Support\Facades\Auth::check())
                @if($tournament->finished)
                    <a href="/{{$tournament->id}}/results">results</a>
                @elseif($user->is_admin)
                    <a href="/{{$tournament->id}}/run/q/conf/{{$tournament->squads[0]->id}}">run</a>
                @else
                    <a href="/{{$tournament->id}}/apply">apply</a>
                @endif
            @endif
        @endforeach
    </div>
@endsection

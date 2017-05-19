@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($tournaments as $tournament)
            <h1>{{ $tournament->name }}</h1>
            <input type="hidden" value="{{$tournament->id}}">
            <ul>
                <li>Type: {{ $tournament->type }}</li>
                <li>Location: {{ $tournament->location }}</li>
                <li>Oil type: {{ $tournament->oil_type }}</li>
                <li>Description: {{ $tournament->description }}</li>
                <li>Handicap: {{ $tournament->handicap_type }}, {{$tournament->handicap_value}}</li>
                <li>Squads:
                    <ul>
                        @foreach($tournament->squads as $squad)
                            <li>{{$squad->date}}, {{$squad->start_time}}-{{$squad->end_time}}</li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <a href="/{{$tournament->id}}/players">players</a>
            @if(\Illuminate\Support\Facades\Auth::check())
                @if($user->is_admin)
                    <a href="/{{$tournament->id}}/run/q/conf/{{$tournament->squads[0]->id}}">run</a>
                @else
                    <a href="/{{$tournament->id}}/apply">apply</a>
                @endif
            @endif
        @endforeach
    </div>
@endsection

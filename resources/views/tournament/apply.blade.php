@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{url("$tournament->id/sendApplication")}}" method="post">
            {{ csrf_field() }}
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" value="{{$tournament->id}}" id="tournament-id">
            <div>
                <label for="squad">Squad:</label>
                <select id="squad" name="squad">
                    @foreach($tournament->squads as $squad)
                        <option value="{{$squad->id}}" selected>{{"$squad->date $squad->start_time"}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="price">Price:</label>
                <span id="price">{{$tournament->qualification->fee}} BYN</span>
            </div>
            <div>
                <label for="fill">Places left:</label>
                <span id="fill"></span>
            </div>
            <div>
                <label for="players">Players:</label>
                <ul id="players"></ul>
            </div>
            <button type="submit" id="apply-button">APPLY</button>
        </form>
        <div id="error"></div>
    </div>
@endsection

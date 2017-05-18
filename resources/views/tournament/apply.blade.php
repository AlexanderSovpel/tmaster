@extends('layouts.app')

@section('content')
    <div class="container">

        <form action="{{url("$tournament->id/sendApplication")}}" method="post">
            {{ csrf_field() }}
            {{--<input type="hidden" value="{{$tournament->id}}" id="tId">--}}
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
                <span id="price">{{$tournament->qualification_fee}}</span>
            </div>
            <div>
                <label for="fill">Places left:</label>
                <span id="fill"></span>
            </div>
            <div>
                <label for="players">Players:</label>
                <ul id="players"></ul>
            </div>
            <div id="error"></div>

            <button type="submit" id="applyButton">APPLY</button>
        </form>
    </div>
@endsection

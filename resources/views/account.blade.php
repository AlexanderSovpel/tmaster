@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="info">
            <a href="/account/edit" id="edit-link">редактировать</a>
            <div id="user-photo">
                <img src="">
            </div>
            <div id="user-data">
                <h2>{{$user->name}} {{$user->surname}}</h2>
                <p>{{$user->gender}}</p>
                <p>{{$user->birthday}} ({{$user->age}})</p>
                <p>{{$user->phone}}</p>
                <p>{{$user->email}}</p>
            </div>
        </div>
        <hr>
        {{--<div>{{$user->games}}</div>--}}
        <div id="statistics"></div>
        <div id="error"></div>
    </div>
@endsection
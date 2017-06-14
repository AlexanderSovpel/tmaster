@extends('layouts.app')

@section('content')
    <div class="user panel panel-default">
        <div id="info" class="panel-heading">
            <a href="/account/edit" id="edit-link">редактировать</a>
            <div id="user-photo">
                <img src="{{asset('img/placeholder_user.png')}}">
            </div>
            <div id="user-data">
                <h1>{{$user->name}} {{$user->surname}}</h1>
                <p>{{$user->gender}}</p>
                <p>{{$user->birthday}} ({{$user->age}})</p>
                <p>{{$user->phone}}</p>
                <p>{{$user->email}}</p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div>
            <h3>Статистика</h3>
            <div id="statistics">
            </div>
        </div>
    </div>
@endsection

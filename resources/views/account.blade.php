@extends('layouts.app')

@section('content')
    <div class="user panel panel-default">
        <div id="info" class="panel-heading">
            <a href="/account/edit" id="edit-link">редактировать</a>
            <div id="user-photo">
                <img src="{{asset('img/avatars/'.$user->avatar)}}">
                <div class="change-avatar">изменить фото</div>
                <div class="delete-avatar"><span aria-hidden="true">&times;</span></div>
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

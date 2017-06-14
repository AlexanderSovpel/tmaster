@extends('layouts.app')

@section('content')
    <div class="user panel panel-default">
        <div id="info" class="panel-heading">
            <a href="/account/edit" id="edit-link">редактировать</a>
            <div id="user-photo">
              @if($user->avatar)
              <img src="{{asset('img/avatars/'.$user->avatar)}}">
              @else
                <img src="{{asset('img/placeholder-user.png')}}">
              @endif
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

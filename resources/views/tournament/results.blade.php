@extends('layouts.app')

{{--TODO: show all results--}}
@section('content')
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="/{{$tournament->id}}/run/q/rest">Квалификация</a>
        </li>
        <li role="presentation">
            <a href="/{{$tournament->id}}/run/rr/rest">Финал</a>
        </li>
        <li role="presentation">
            <a href="#">Итоги</a>
        </li>
    </ul>
@endsection
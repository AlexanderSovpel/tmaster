@extends('layouts.app')
@section('content')
@include('partial.breadcrumb', ['page' => 'Подача заявки'])
<div class="error"></div>
<article class="apply panel panel-default">
    <div class="panel-heading"><h1>Подача заявки</h1></div>
    <form action="{{url("$tournament->id/sendApplication")}}" method="post" class="">
            {{ csrf_field() }}

            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" value="{{$tournament->id}}" id="tournament-id">
        <div class="panel-body">
            <div class="form-group row">
                <label for="squad" class="col-md-6">Поток</label>
                <select id="squad" name="squad" class="form-control data col-md-6">
                    @foreach($tournament->squads()->orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->get() as $squad)
                        <option value="{{$squad->id}}" selected>{{date('j.m.Y', strtotime($squad->date))}} {{date('H:i', strtotime($squad->start_time))}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label for="price" class="col-md-6">Стоимость участия</label>
                <span id="price" class="data col-md-6">{{$tournament->qualification->fee}} BYN</span>
            </div>
            <div class="form-group row">
                <label for="fill" class="col-md-6">Осталось мест</label>
                <span id="fill" class="data col-md-6"></span>
            </div>
            <div class="form-group row">
                <label for="players" class="col-md-6">Заявки</label>
                <ol class="players-list data col-md-6" id="players">
                </ol>
                <div class="clearfix"></div>
            </div>
          </div>
        <button type="submit" id="apply-button" class="btn tournament-btn">подать заявку</button>
        <div class="clearfix"></div>
        </form>
    </article>
@endsection

@extends('layouts.app')
@section('content')
@include('partial.breadcrumb', ['page' => 'Подача заявки'])
    <article class="apply">
      <h1>Подача заявки</h1>
        <form action="{{url("$tournament->id/sendApplication")}}" method="post">
            {{ csrf_field() }}

            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" value="{{$tournament->id}}" id="tournament-id">
            <div class="inputs">
            <div class="form-group">
                <label for="squad">Поток:</label>
                <select id="squad" name="squad" class="form-control data">
                    @foreach($tournament->squads as $squad)
                        <option value="{{$squad->id}}" selected>{{"$squad->date $squad->start_time"}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="price">Стоимость участия:</label>
                <span id="price" class="data">{{$tournament->qualification->fee}} BYN</span>
            </div>
            <div>
                <label for="fill">Осталось мест:</label>
                <span id="fill" class="data"></span>
            </div>
            <div>
                <label for="players">Участники:</label>
                <ol class="players-list data" id="players">
                </ol>
            </div>
          </div>
            <button type="submit" id="apply-button" class="tournament-btn">подать заявку</button>
        </form>
    </article>
    <div id="error"></div>
@endsection

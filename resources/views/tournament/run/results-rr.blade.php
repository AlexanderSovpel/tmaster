@extends('layouts.run')

@section('process')
    <h2>Результаты</h2>
    <form action="/{{$tournament->id}}/results" method="get">
        {{ csrf_field() }}
        @include('partial.final-results')
        <button type="submit" class="btn">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
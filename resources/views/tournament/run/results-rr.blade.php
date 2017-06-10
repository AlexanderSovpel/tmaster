@extends('layouts.run')

@section('process')
    <h1>Результаты</h1>
    <form action="/{{$tournament->id}}/results" method="get">
        {{ csrf_field() }}
        @include('partial.final-results')
        <button type="submit" class="btn">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection

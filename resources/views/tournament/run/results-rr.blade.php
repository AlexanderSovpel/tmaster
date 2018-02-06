@extends('layouts.run')

@section('process')
<article class="panel panel-default part">
    <div class="panel-heading"><h1>Результаты</h1></div>
    <form action="/{{$tournament->id}}/results" method="get" class="panel-body">
        {{ csrf_field() }}
        @include('partial.final-results')
        <button type="submit" class="btn">завершить игру</button>
        <div id="error"></div>
    </form>
</article>
@endsection

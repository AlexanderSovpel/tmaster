@extends('layouts.run')

@section('process')
<h1>Квалификация - Результаты</h1>
<form action="/{{$tournament->id}}/run/rr/conf/" method="get">
    {{ csrf_field() }}
    @include('partial.qualification-results')
    @if ($tournament->roundRobin->players)
    <button type="submit" class="btn">начать финал</button>
    @else
    <button type="submit" class="btn">завершить соревнование</button>
    @endif
</form>
@endsection

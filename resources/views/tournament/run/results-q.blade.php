@extends('layouts.run')

@section('process')
<h1>Квалификация - Результаты</h1>
<form action="/{{$tournament->id}}/run/rr/conf/" method="get">
    {{ csrf_field() }}
    @include('partial.qualification-results')
    <button type="submit" class="btn">начать финал</button>
</form>
@endsection

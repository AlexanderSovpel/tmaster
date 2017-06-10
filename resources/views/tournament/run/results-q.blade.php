@extends('layouts.run')

@section('process')
<h2>Квалификация - Результаты</h2>
<form action="/{{$tournament->id}}/run/rr/conf/" method="get">
    {{ csrf_field() }}
    <input type="hidden" name="players" value="{{json_encode($qPlayers)}}">
    @include('partial.qualification-results')
    <button type="submit" class="btn">начать финал</button>
</form>
@endsection

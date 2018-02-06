@extends('layouts.run')

@section('process')
<article class="panel panel-default part">
    <div class="panel-heading"><h1>Результаты потока</h1></div>
    <form action="/{{$tournament->id}}/run/q/conf/{{$currentSquadId}}" method="get" class="panel-body">
        {{ csrf_field() }}
        @include('partial.squad-results')
        <button type="submit" class="btn">завершить поток</button>
        <div id="error"></div>
    </form>
  </article>
@endsection

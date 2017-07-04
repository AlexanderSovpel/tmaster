@extends('layouts.run')

@section('process')
<article class="panel panel-default part">
  <div class="panel-header"><h1>Квалификация - Результаты</h1></div>
  <form action="/{{$tournament->id}}/run/rr/conf/" method="get" class="panel-body">
      {{ csrf_field() }}
      @include('partial.qualification-results')
      @if ($tournament->roundRobin->players)
      <button type="submit" class="btn">начать финал</button>
      @else
      <button type="submit" class="btn">завершить соревнование</button>
      @endif
  </form>
</article>
@endsection

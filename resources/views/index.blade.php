@extends('layouts.app')

@section('content')
    <section class="container">
        @if($user->is_admin)
            <a href="/newTournament" class="add-tournament-btn">добавить соревнование</a>
        @endif
        @foreach($tournaments as $tournament)
            @include('partial.tournament')
        @endforeach
    </section>
@endsection
<!-- @php
$arr = array(1, 2, 3, 4, 5, 6);
$lastIndex = count($arr) - 1;
var_dump($arr);
echo "<br>";
for ($i = 0; $i < $lastIndex - 1; ++$i) {
  array_unshift($arr, array_pop($arr));
  list($arr[$lastIndex], $arr[0]) = array($arr[0], $arr[$lastIndex]);
  var_dump($arr);
  echo "<br>";
}
@endphp -->

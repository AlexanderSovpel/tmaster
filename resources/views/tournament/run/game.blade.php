@extends('layouts.run')
@section('process')
<div class="qualification-games">
  <input type="hidden" name="current_game" id="current-game" value="0">
  {{--@php
    $lanesTmp = $lanes;
  @endphp--}}

  @for($gameIndex = 0; $gameIndex < $tournament->qualification->entries; ++$gameIndex)
    @include('partial.qualification-game', ['gameIndex' => $gameIndex])

    @php
      foreach($players as $index => $player) {
        $lanesTmp = $lanes;
        $laneIndex = array_search($playersLanes[$index], $lanesTmp);
        array_push($lanesTmp, array_shift($lanesTmp));
        $playersLanes[$index] = $lanesTmp[$laneIndex];
      }
    @endphp
  @endfor

  <nav aria-label="Page navigation">
    <ul class="pagination" id="game-pagination">
      @for($gameIndex = 0; $gameIndex < $tournament->qualification->entries; ++$gameIndex)
      <li><a href="#">{{$gameIndex + 1}}</a></li>
      @endfor
    </ul>
  </nav>
</div>
@endsection

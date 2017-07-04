@extends('layouts.run')

@section('process')
<div class="round-robin-games">
  <input type="hidden" name="current_game" id="current-game" value="0">
  @php
    $lanesTmp = $lanes;
  @endphp

  @for($roundIndex = 0; $roundIndex < $roundCount; ++$roundIndex)
    @include('partial.final-round', ['roundIndex' => $roundIndex])

    @php
      array_push($lanesTmp, array_shift($lanesTmp));
      foreach($players as $index => $player) {
        $player->lane = $lanesTmp[$index / 2];
      }

      array_unshift($players, array_pop($players));
      list($players[0], $players[$lastPlayerIndex]) = array($players[$lastPlayerIndex], $players[0]);
    @endphp
  @endfor

  <nav aria-label="Page navigation">
    <ul class="pagination" id="game-pagination">
      @for($roundIndex = 0; $roundIndex < $roundCount; ++$roundIndex)
      <li><a href="#">{{$roundIndex + 1}}</a></li>
      @endfor
    </ul>
  </nav>
</div>
@endsection

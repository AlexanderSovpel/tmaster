<section class="panel panel-default game">
  <div class="panel-heading"><h1>Игра {{$gameIndex + 1}}</h1></div>
  <form action="/{{$tournament->id}}/run/q/rest/{{$currentSquad->id}}" method="post" class="panel-body lanes">
      {{ csrf_field() }}
      @foreach($lanes as $laneIndex => $lane)
      <article class="lane">
        {{-- <h3>Дорожка {{$lanes[$laneIndex]}}</h3> --}}
        <h3>Дорожка {{$lane}}</h3>
        <div class="lane-players">
        @foreach($players as $player)
          @if($player->lane == $lane)
          {{--@if($player->lane == $lanes[$laneIndex])--}}
          <div class="input-group player">
              <input type="hidden" class="player-id input-group-addon" value="{{$player->id}}">
              <label for="player-{{$player->id}}" class="input-group-addon player-name">
                  {{$player->surname.' '.$player->name}}
              </label>
              <input type="number"
                     id="player-{{$player->id}}"
                     class="form-control player-result
                     @if(isset($playedGames[$player->id][$gameIndex]))
                     played
                     @endif
                     "
                     min="0" max="300"
                     value="{{$playedGames[$player->id][$gameIndex]->result or ''}}"
                     old_value="{{$playedGames[$player->id][$gameIndex]->result or ''}}"
                     onfocus="this.old_value = this.value">
              <span class="player-bonus input-group-addon">
                @if($player->gender == $tournament->handicap->type)
                    +{{$tournament->handicap->value}}
                @else
                    +0
                @endif
              </span>
              {{--<span class="input-group-btn">--}}
                  {{--<button class="btn btn-secondary post-result" type="button">--}}
                      {{--<span class="glyphicon glyphicon-ok"></span>--}}
                  {{--</button>--}}
              {{--</span>--}}
          </div>
          @endif
        @endforeach
        </div>
      </article>
      @endforeach
      @if ($gameIndex != $tournament->qualification->entries - 1)
      <button type="button" class="btn finish-game">завершить игру</button>
      @else
      <button type="submit" class="btn finish-game">показать результаты</button>
      @endif
  </form>
</section>

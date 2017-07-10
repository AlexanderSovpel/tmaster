<section class="panel panel-default game">
  <div class="panel-heading">
    <h1>Раунд {{$roundIndex + 1}}</h1>
  </div>
    <form action="/{{$tournament->id}}/run/rr/rest" method="get" class="panel-body lanes">
        {{ csrf_field() }}

        @for($laneIndex = 0, $j = 0, $h = $lastPlayerIndex; $laneIndex < count($lanes); ++$laneIndex, ++$j, --$h)
        <article class="lane opponents">
          <h3>Дорожка {{$lanes[$laneIndex]}}</h3>
          <div class="lane-players">
            <div class="input-group opponent">
                <input type="hidden" class="opponent-id input-group-addon" value="{{$players[$j]->id}}">
                <label for="opponent-{{$players[$j]->id}}" class="input-group-addon opponent-name">
                    {{$players[$j]->surname.' '.$players[$j]->name}}
                </label>
                <input type="text"
                       id="opponent-{{$players[$j]->id}}"
                       class="form-control opponent-result"
                       value="{{$playedGames[$players[$j]->id][$roundIndex]->result or ''}}"
                       old_value="{{$playedGames[$players[$j]->id][$roundIndex]->result or ''}}"
                       onfocus="this.old_value = this.value">
                <span class="opponent-bonus input-group-addon">
                    {{$playedGames[$players[$j]->id][$roundIndex]->bonus or ''}}
                </span>
                <span class="input-group-btn">
                    <button class="btn btn-secondary post-opponent-result" type="button">
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </span>
            </div>
            <div class="input-group opponent">
                <span class="input-group-btn">
                    <button class="btn btn-secondary post-opponent-result" type="button">
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </span>
                <span class="opponent-bonus input-group-addon">
                    {{$playedGames[$players[$h]->id][$roundIndex]->bonus or ''}}
                </span>
                <input type="text"
                       id="opponent-{{$players[$h]->id}}"
                       class="form-control opponent-result"
                       value="{{$playedGames[$players[$h]->id][$roundIndex]->result or ''}}"
                       old_value="{{$playedGames[$players[$h]->id][$roundIndex]->result or ''}}"
                       onfocus="this.old_value = this.value">
                <label for="opponent-{{$players[$h]->id}}" class="input-group-addon opponent-name">
                    {{$players[$h]->surname.' '.$players[$h]->name}}
                </label>
                <input type="hidden" class="opponent-id input-group-addon" value="{{$players[$h]->id}}">
            </div>
          </div>
        </article>
        @endfor

        @if ($roundIndex != $roundCount - 1)
        <button type="button" class="btn finish-game">завершить раунд</button>
        @else
        <button type="submit" class="btn finish-game">показать результаты</button>
        @endif
    </form>
  </section>

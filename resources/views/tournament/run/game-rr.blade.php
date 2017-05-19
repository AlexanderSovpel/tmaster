@extends('layouts.run')

@section('process')
    <h2>Игра</h2>
    <form action="/{{$tournamentId}}/run/rr/rest" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="players" value="{{$players}}">
        @for($i = 0; $i < $roundCount; ++$i)
            <div class="round">
                <h3>Round {{$i+1}}</h3>
                @for($j = 0, $h = $lastPlayerIndex; $j < ($lastPlayerIndex + 1) / 2; ++$j, --$h)
                    <div class="opponents">
                        <div class="input-group opponent">
                            <input type="hidden" class="opponent-id input-group-addon" value="{{$players[$j]->id}}">
                            <label for="opponent-{{$players[$j]->id}}" class="input-group-addon opponent-name">
                                {{$players[$j]->surname.' '.$players[$j]->name}}
                            </label>
                            <input type="text"
                                   id="opponent-{{$players[$j]->id}}"
                                   class="form-control opponent-result"
                                   value="{{$playedGames[$players[$j]->id][$i]->result or ''}}"
                                   old_value="{{$playedGames[$players[$j]->id][$i]->result or ''}}"
                                   onfocus="this.old_value = this.value">
                            <span class="opponent-bonus input-group-addon">
                                {{$playedGames[$players[$j]->id][$i]->bonus or ''}}
                            </span>
                            <span class="input-group-btn">
                                <button class="btn btn-secondary post-opponent-result" type="button">set</button>
                            </span>
                        </div>
                        <div class="input-group opponent">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary post-opponent-result" type="button">set</button>
                            </span>
                            <span class="opponent-bonus input-group-addon">
                                {{$playedGames[$players[$h]->id][$i]->bonus or ''}}
                            </span>
                            <input type="text"
                                   id="opponent-{{$players[$h]->id}}"
                                   class="form-control opponent-result"
                                   value="{{$playedGames[$players[$h]->id][$i]->result or ''}}"
                                   old_value="{{$playedGames[$players[$h]->id][$i]->result or ''}}"
                                   onfocus="this.old_value = this.value">
                            <label for="opponent-{{$players[$h]->id}}" class="input-group-addon opponent-name">
                                {{$players[$h]->surname.' '.$players[$h]->name}}
                            </label>
                            <input type="hidden" class="opponent-id input-group-addon" value="{{$players[$h]->id}}">
                        </div>
                    </div>
                @endfor
            </div>
            @php
                array_unshift($players, array_pop($players));
                $temp = $players[0];
                $players[0] = $players[$lastPlayerIndex];
                $players[$lastPlayerIndex] = $temp;
            @endphp
        @endfor
        <button type="submit">завершить игру</button>
        <div id="error"></div>
    </form>
@endsection
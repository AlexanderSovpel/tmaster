@extends('layouts.app')

@section('content')
    <div class="container">
        <input type="hidden" name="tournament" value="{{$tournament->id}}">
        <input type="hidden" name="part" value="{{$part}}">
        <input type="hidden" name="stage" value="{{$stage or ''}}">
        <input type="hidden" name="currentSquad" value="{{$currentSquadId or ''}}">
        <input type="hidden" name="squadFinished" value="{{$squadFinished or ''}}">
        <h1>{{$tournament->name}}</h1>
        <div>
            <div class="part-nav">
                <ul class="list-group">
                    <li class="list-group-item">Квалификация
                        <ul class="list-group">
                            @for($i = 0; $i < count($tournament->squads); ++$i)
                                <li
                                        @if(isset($currentSquad))
                                        @if($currentSquad->id == $tournament->squads[$i]->id)
                                        class="list-group-item active"
                                        @else
                                        class="list-group-item"
                                        @endif
                                        @else
                                        class="list-group-item"
                                        @endif
                                >Поток {{$i + 1}}</li>
                            @endfor
                        </ul>
                    </li>
                    <li class="list-group-item">Финал
                        <ul class="list-group">
                            @for($j = 0; $j < $tournament->rr_players - 1; ++$j)
                                <li class="list-group-item">Раунд {{$j + 1}}</li>
                            @endfor
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="game-process">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li
                                @if($stage == 'conf')
                                class="active"
                                @else
                                class=""
                                @endif
                        ><a href="#">подтверждение</a></li>

                        <li
                                @if($stage == 'draw')
                                class="active"
                                @else
                                class=""
                                @endif
                        ><a href="#">жеребьёвка</a></li>

                        <li
                                @if($stage == 'game')
                                class="active"
                                @else
                                class=""
                                @endif
                        ><a href="#">игра</a></li>

                        <li
                                @if($stage == 'rest')
                                class="active"
                                @else
                                class=""
                                @endif
                        ><a href="#">результаты</a></li>
                    </ul>
                </nav>
                @yield('process')
            </div>
        </div>
    </div>
@endsection
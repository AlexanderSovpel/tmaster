@extends('layouts.app')

@section('content')
    <div class="container">
      @include('partial.breadcrumb', ['page' => 'Проведение соревнования'])
        <input type="hidden" name="tournament" value="{{$tournament->id}}">
        <input type="hidden" name="part" value="{{$part}}">
        <input type="hidden" name="stage" value="{{$stage or ''}}">
        <input type="hidden" name="currentSquad" value="{{$currentSquadId or ''}}">
        <input type="hidden" name="squadFinished" value="{{$squadFinished or ''}}">
        <!-- <h1>{{$tournament->name}}</h1> -->
        <div>
            <div class="part-nav stages">
              <h3>Этап</h3>
                <ul class="list-group">
                    <li class="list-group-item">Квалификация
                        <ul class="list-group">
                            @for($i = 0; $i < count($tournament->squads); ++$i)
                                <li
                                        @if(isset($currentSquadId))
                                        @if($currentSquadId == $tournament->squads[$i]->id)
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
                            @for($j = 0; $j < $tournament->roundRobin->players - 1; ++$j)
                                <li class="list-group-item">Раунд {{$j + 1}}</li>
                            @endfor
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="game-process">
              <div class="row bs-wizard" style="border-bottom:0;">
                <div class="col-xs-3 bs-wizard-step active">
                  <div class="text-center bs-wizard-stepnum">Регистрация</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                </div>

                <div class="col-xs-3 bs-wizard-step disabled">
                  <div class="text-center bs-wizard-stepnum">Жеребьёвка</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                </div>

                <div class="col-xs-3 bs-wizard-step disabled">
                  <div class="text-center bs-wizard-stepnum">Игра</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                </div>

                <div class="col-xs-3 bs-wizard-step disabled">
                  <div class="text-center bs-wizard-stepnum">Результаты</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                </div>
              </div>
                <!-- <nav aria-label="Page navigation">
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
                </nav> -->
              <article class="part">
                @yield('process')
              </article>
            </div>
        </div>
    </div>
@endsection

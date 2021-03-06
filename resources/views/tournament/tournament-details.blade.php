@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/">Соревнования</a></li>
        <li>{{$tournament->name}}</li>
    </ol>
    <article class="tournament panel panel-default">
        <input type="hidden" value="{{$tournament->id}}">
        <div class="panel-heading">
          <h1>{{ $tournament->name }}</h1>

          @if(\Illuminate\Support\Facades\Auth::check() && $user->is_admin)
          <div class="dropdown">
            <button class="btn menu-btn dropdown-toggle" type="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="glyphicon glyphicon-option-vertical"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              @if(!$tournament->finished)
              <li><a href="/{{$tournament->id}}/run/q/conf/{{$tournament->squads[0]->id}}">Провести</a></li>
              <li><a href="/{{$tournament->id}}/editTournament">Редактировать</a></li>
              <li role="separator" class="divider"></li>
              @endif
              <li><a href="/{{$tournament->id}}/deleteTournament">Удалить</a></li>
            </ul>
          </div>
          @endif

          <div class="clearfix"></div>
        </div>
        <div class="panel-body">
        <p class="description">{{$tournament->description}}</p>
        <p class="decree">
            Соревнования проводятся в соответствии с Положением о рейтинговых соревнованиях, этапах Чемпионата Беларуси
            по боулингу.
        </p>
        <div class="details row">
            <p class="control-label col-md-6">Даты проведения</p>
            <p class="detail col-md-6">
              {{date('j.m.Y', strtotime($tournament->squads()->orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->first()->date))}} &mdash;
              {{(isset($tournament->roundRobin)) ?
                date('j.m.Y', strtotime($tournament->roundRobin->date)) :
                date('j.m.Y', strtotime($tournament->squads()->orderBy('date', 'DESC')->orderBy('start_time', 'DESC')->first()->date))}}
            </p>
            <p class="control-label col-md-6">Место проведения</p>
            <p class="detail col-md-6">{{$tournament->location}}</p>
            <p class="control-label col-md-6">Вступительный взнос</p>
            <p class="detail col-md-6">{{$tournament->qualification->fee}} BYN</p>
            <p class="control-label col-md-6">Контактное лицо</p>
            @if($tournament->contact)
            <p class="detail col-md-6">
                {{$tournament->contact->surname}} {{$tournament->contact->name}}<br>
                {{$tournament->contact->phone}}<br>
                {{$tournament->contact->email}}
            </p>
            @endif
        </div>
        <div class="clearfix"></div>
        <p class="penalty">
            ВНИМАНИЕ! Вводится штраф при неявке на поток. Размер штрафа равен сумме стартового взноса для этого этапа и
            будет взиматься до участия в следующем этапе. Чтобы избежать штрафных санкций, игрок должен предупредить
            главного судью соревнований накануне своего запланированного участия до 21:00.
        </p>
        <h3>Программа соревнования</h3>
        @php
            $days = array();
            foreach ($tournament->squads as $squad) {
            if (!in_array($squad->date, $days)) {
                $days[] = $squad->date;
            }
        }
        @endphp
        <ul class="schedule">
            @foreach($days as $key => $day)
                <li class="schedule-day">{{date('j.m.Y', strtotime($day))}}:
                    <ul>
                        @foreach($tournament->squads()->orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->get() as $index => $squad)
                            @if($squad->date == $day)
                                <li class="schedule-time">
                                    <span class="time">{{date('H:i', strtotime($squad->start_time))}}-{{date('H:i', strtotime($squad->end_time))}}</span>
                                    {{$index + 1}}-ая группа, {{$squad->max_players}}
                                    участников, {{$tournament->qualification->games * $tournament->qualification->entries}}
                                    игр квалификации
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
            @if(isset($tournament->roundrobin))
            <li class="schedule-day">
                {{date('j.m.Y', strtotime($tournament->roundrobin->date))}}:
                <ul>
                    <li class="schedule-time">
                        <span class="time">{{date('H:i', strtotime($tournament->roundrobin->start_time))}}
                            -{{date('H:i', strtotime($tournament->roundrobin->end_time))}}</span>
                        финал Round-Robin, {{$tournament->roundrobin->players}} лучших игроков
                    </li>
                </ul>
            </li>
            @endif
        </ul>
        @if(!$tournament->finished && \Illuminate\Support\Facades\Auth::check())
            @if($user->is_admin)
            <a href="/{{$tournament->id}}/run/q/conf/{{$tournament->squads[0]->id}}" class="tournament-btn-lg btn">начать соревнование</a>
            @else
            <a href="/{{$tournament->id}}/apply" class="btn tournament-btn-lg">подать заявку</a>
            @endif
        @endif
        <div class="clearfix"></div>
        <ol class="breadcrumb">
            <li><a href="/{{$tournament->id}}/players">Заявки</a></li>
            <li><a href="/{{$tournament->id}}/results">Результаты</a></li>
        </ol>
      </div>
    </article>
@endsection

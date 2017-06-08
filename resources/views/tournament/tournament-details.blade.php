@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/">Соревнования</a></li>
        <li>{{$tournament->name}}</li>
    </ol>
    <article class="tournament panel panel-default">
        <input type="hidden" value="{{$tournament->id}}">
        <div class="panel-heading"><h1>{{ $tournament->name }}</h1></div>
        <p class="description">{{$tournament->description}}</p>
        <p class="decree">
            Соревнования проводятся в соответствии с Положением о рейтинговых соревнованиях, этапах Чемпионата Беларуси
            по боулингу.
        </p>
        <div class="details row">
            <p class="control-label col-md-6">Даты проведения</p>
            <p class="detail col-md-6">{{$tournament->squads[0]->date}} &mdash; {{$tournament->roundRobin->date}}</p>
            <p class="control-label col-md-6">Место проведения</p>
            <p class="detail col-md-6">{{$tournament->location}}</p>
            <p class="control-label col-md-6">Вступительный взнос</p>
            <p class="detail col-md-6">{{$tournament->qualification->fee}} BYN</p>
            <p class="control-label col-md-6">Контактное лицо</p>
            <p class="detail col-md-6">
                {{$tournament->contact->surname}} {{$tournament->contact->name}}<br>
                {{$tournament->contact->phone}}<br>
                {{$tournament->contact->email}}
            </p>
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
                <li class="schedule-day">{{$day}}:
                    <ul>
                        @foreach($tournament->squads as $index => $squad)
                            @if($squad->date == $day)
                                <li class="schedule-time">
                                    <span class="time">{{$squad->start_time}}-{{$squad->end_time}}</span>
                                    {{$index + 1}}-ая группа, {{$squad->max_players}}
                                    участников, {{$tournament->qualification->games * $tournament->qualification->entries}}
                                    игр квалификации
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
            <li class="schedule-day">
                {{$tournament->roundrobin->date}}:
                <ul>
                    <li class="schedule-time">
                        <span class="time">{{$tournament->roundrobin->start_time}}
                            -{{$tournament->roundrobin->end_time}}</span>
                        финал Round-Robin, {{$tournament->roundrobin->players}} лучших игроков
                    </li>
                </ul>
            </li>
        </ul>
        @if(!$tournament->finished)
            @if($user->is_admin)
            <a href="/{{$tournament->id}}/run/q/conf/{{$tournament->squads[0]->id}}" class="tournament-btn btn">начать соревнование</a>
            @else
            <a href="/{{$tournament->id}}/apply" class="btn tournament-btn-lg">подать заявку</a>
            @endif
        @endif
        <div class="clearfix"></div>
        <ol class="breadcrumb">
            <li><a href="/{{$tournament->id}}/players">Участники</a></li>
            <li>
                @if($tournament->finished)
                    <a href="/{{$tournament->id}}/results">Результаты</a>
                @else
                    Результаты
                @endif
            </li>
            <li class="#">Фотоотчет</li>
        </ol>
    </article>
@endsection
<article class="tournament">
<input type="hidden" value="{{$tournament->id}}">
<h1>{{ $tournament->name }}</h1>
<p class="date">{{$tournament->squads[0]->date}} &mdash; {{$tournament->roundRobin->date}}</p>
@if(!$tournament->finished)
  <p class='open'>регистрация открыта</p>
@else
  <p class='finished'>соревнование завершено</p>
@endif
<div class="info">
    <p class="info-label">Программа намазки</p>
    <p class="info-data">{{ $tournament->oil_type }}</p>
    <p class="info-label">Гандикап</p>
    <p class="info-data">{{ $tournament->handicap->type }}, {{$tournament->handicap->value}}</p>
    <p class="info-label">Квалификация</p>
      @foreach($tournament->squads as $squad)
          <p class="info-data">{{$squad->date}}, {{$squad->start_time}} &ndash; {{$squad->end_time}}</p>
      @endforeach
    <p class="info-label">Финал</p>
    <p class="info-data">{{$tournament->roundRobin->date}}, {{$tournament->roundRobin->start_time}} &ndash; {{$tournament->roundRobin->end_time}}</p>
    <p class="info-label">Место проведения</p>
    <p class="info-data">{{ $tournament->location }}</p>
    <p class="info-label fee-label">
      <img src="{{asset('img/iconmonstr-coin-3.svg')}}">
    </p>
    <p class="info-data fee">{{$tournament->qualification->fee}} BYN</p>
    <!-- <li>Contact: {{$tournament->contact->surname}} {{$tournament->contact->name}},
        {{$tournament->contact->phone}},
        {{$tournament->contact->email}}</li> -->
</div>

@if(\Illuminate\Support\Facades\Auth::check() && !$tournament->finished)
  @if($user->is_admin)
    <a href="/{{$tournament->id}}/run/q/conf/{{$tournament->squads[0]->id}}" class="tournament-btn">начать соревнование</a>
  @else
    <a href="/{{$tournament->id}}/apply" class="tournament-btn">подать заявку</a>
  @endif
@endif

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

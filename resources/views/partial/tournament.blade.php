<article class="tournament panel panel-default">
  <input type="hidden" value="{{$tournament->id}}">
  <h1><a href="/{{$tournament->id}}/details">{{ $tournament->name }}</a></h1>

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

  <p class="date">
    {{date('j.m.Y', strtotime($tournament->squads()->orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->first()->date))}} &mdash;
    {{(isset($tournament->roundRobin)) ?
      date('j.m.Y', strtotime($tournament->roundRobin->date)) :
      date('j.m.Y', strtotime($tournament->squads()->orderBy('date', 'DESC')->orderBy('start_time', 'DESC')->first()->date))}}
    </p>

  @if(!$tournament->finished)
  <p class='tournament-open'>регистрация открыта</p>
  @else
  <p class='tournament-finished'>соревнование завершено</p>
  @endif

  <div class="info row">
    <p class="info-label col-md-6">Программа намазки</p>
    <p class="info-data col-md-6">{{ $tournament->oil_type }}</p>
  </div>

  <div class="info row">
    <p class="info-label col-md-6">Гандикап</p>
    <p class="info-data col-md-6">{{ $tournament->handicap->type }},
      {{$tournament->handicap->value}}</p>
  </div>

  <div class="info row">
    <p class="info-label col-md-6">Квалификация</p>
    <div class="col-md-6">
    @foreach($tournament->squads()->orderBy('date', 'ASC')
      ->orderBy('start_time', 'ASC')->get() as $squad)
      <p class="info-data">{{date('j.m.Y', strtotime($squad->date))}},
        {{date('H:i', strtotime($squad->start_time))}} &ndash; {{date('H:i',
        strtotime($squad->end_time))}}</p>
    @endforeach
    </div>
  </div>

  @if(isset($tournament->roundRobin))
  <div class="info row">
    <p class="info-label col-md-6">Финал</p>
    <p class="info-data col-md-6">{{date('j.m.Y',
      strtotime($tournament->roundRobin->date))}},
      {{date('H:i', strtotime($tournament->roundRobin->start_time))}} &ndash;
      {{date('H:i', strtotime($tournament->roundRobin->end_time))}}</p>
  </div>
  @endif

  <div class="info row">
    <p class="info-label col-md-6">Место проведения</p>
    <p class="info-data col-md-6">{{ $tournament->location }}</p>
  </div>

  <div class="info row">
    <p class="info-label fee-label col-md-6"><img src="{{asset('img/iconmonstr-coin-3.svg')}}"></p>
    <p class="info-data fee col-md-6">{{$tournament->qualification->fee}} BYN</p>
  </div>

@if(\Illuminate\Support\Facades\Auth::check() && !$tournament->finished)
  @if($user->is_admin)
  <a href="/{{$tournament->id}}/run/q/conf/{{$tournament->squads[0]->id}}"
    class="tournament-btn btn">начать соревнование</a>
  @else
  <a href="/{{$tournament->id}}/apply" class="tournament-btn btn">подать заявку</a>
  @endif
@endif

<ol class="breadcrumb">
  <li><a href="/{{$tournament->id}}/players">Заявки</a></li>
  <li>
    <a href="/{{$tournament->id}}/results">Результаты</a>
  </li>
</ol>
</article>

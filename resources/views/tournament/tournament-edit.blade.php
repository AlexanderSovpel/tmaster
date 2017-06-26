@extends('layouts.app')
@section('content')
@include('partial.breadcrumb', ['page' => 'Редактирование соревнования'])

    <div class="row bs-wizard" style="border-bottom:0;">
        <div class="col-xs-1 bs-wizard-step active">
            <div class="text-center bs-wizard-stepnum">Общee</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
        </div>

        <div class="col-xs-2 bs-wizard-step disabled">
            <div class="text-center bs-wizard-stepnum">Гандикап</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
        </div>

        <div class="col-xs-2 bs-wizard-step disabled">
            <div class="text-center bs-wizard-stepnum">Этапы</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
        </div>

        <div class="col-xs-2 bs-wizard-step disabled">
            <div class="text-center bs-wizard-stepnum">Квалификация</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
        </div>

        <div class="col-xs-2 bs-wizard-step disabled">
            <div class="text-center bs-wizard-stepnum">Стоимость</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
        </div>

        <div class="col-xs-2 bs-wizard-step disabled">
            <div class="text-center bs-wizard-stepnum">Финал</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
        </div>

        <div class="col-xs-1 bs-wizard-step disabled">
            <div class="text-center bs-wizard-stepnum">Контакты</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a href="#" class="bs-wizard-dot"></a>
        </div>
    </div>

    <form method="post" action="/{{$tournament->id}}/saveTournament" id="edit-tournament" class="panel panel-default tournament-edit">
        {{csrf_field()}}
        <input type="hidden" id="step" value="0">
        <div class="creation-step">
            <h1>Общая информация</h1>
            <div class="form-group row">
                <label for="name" class="control-label col-md-6">Название</label>
                <input type="text" name="name" id="name" class="form-control col-md-6" required value="{{$tournament->name}}">
            </div>
            <div class="form-group row">
                <label for="location" class="control-label col-md-6">Место проведения</label>
                <input type="text" name="location" id="location" class="form-control col-md-6" required value="{{$tournament->location}}">
            </div>
            <div class="form-group row">
                <label class="control-label col-md-6">Тип турнира</label>
                <div class="choose-type col-md-6">
                    <div class="radio">
                        <label><input type="radio" name="type" value="sport"
                          @if($tournament->type == 'sport')
                          checked
                          @endif
                          >спортивный</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="type" value="commercial"
                          @if ($tournament->type == 'commercial')
                          checked
                          @endif
                          >коммерческий</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="oil-type" class="control-label col-md-6">Программа намазки</label>
                <select class="form-control col-md-6" id="oil-type" name="oil_type">
                    <option value="короткая"
                    @if ($tournament->oil_type == 'короткая')
                    selected
                    @endif
                    >короткая</option>
                    <option value="средняя"
                    @if ($tournament->oil_type == 'средняя')
                    selected
                    @endif
                    >средняя</option>
                    <option value="длинная"
                    @if ($tournament->oil_type == 'длинная')
                    selected
                    @endif
                    >длинная</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="description" class="control-label col-md-6">Описание</label>
                <textarea name="description" id="description" class="form-control col-md-6">{{$tournament->description}}</textarea>
            </div>
        </div>

        <div class="creation-step">
            <h1>Гандикап</h1>
            <div class="form-group row">
                <label for="handicap-type" class="control-label col-md-6">Правило начисления</label>
                <select class="form-control col-md-6" id="handicap-type" name="handicap_type">
                    <option value="средний"
                    @if ($tournament->handicap->type == 'средний')
                    selected
                    @endif
                    >по среднему</option>
                    <option value="женский"
                    @if ($tournament->handicap->type == 'женский')
                    selected
                    @endif
                    >женский</option>
                    <option value="пожилой"
                    @if ($tournament->handicap->type == 'пожилой')
                    selected
                    @endif
                    >пожилой</option>
                    <option value="детский"
                    @if ($tournament->handicap->type == 'детский')
                    selected
                    @endif
                    >детский</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="handicap-value" class="control-label col-md-6">Значение</label>
                <input type="number" id="handicap-value" name="handicap_value" class="form-control col-md-6" value="{{$tournament->handicap->value}}"
                       min="-30" max="30" required>
            </div>
            <div class="form-group row">
                <label for="handicap-max-game" class="control-label col-md-6">Максимальная игра</label>
                <input type="number" id="handicap-max-game" name="handicap_max_game" class="form-control col-md-6"
                       value="{{$tournament->handicap->max_game}}" min="290" max="340" required>
            </div>
        </div>

        <div class="creation-step">
            <h1>Этапы соревнования</h1>
            <div class="form-group qualification">
                <h3>Квалификация</h3>
                <div class="form-group row">
                    <label for="qualification-games" class="control-label col-md-6">Количество блоков игр</label>
                    <input type="number" name="qualification_games" id="qualification-games"
                           class="form-control col-md-6"
                           value="{{$tournament->qualification->games}}" min="1" max="5" required>
                </div>
                <div class="form-group row">
                    <label for="qualification-entries" class="control-label col-md-6">Количество игр в блоке</label>
                    <input type="number" name="qualification_entries" id="qualification-entries"
                           class="form-control col-md-6" value="{{$tournament->qualification->entries}}" min="3" max="10" required>
                </div>
                <div class="form-group row">
                    <label for="qualification-finalists" class="control-label col-md-6">Количество финалистов</label>
                    <input type="number" name="qualification_finalists" id="qualification-finalists"
                           class="form-control col-md-6" value="{{$tournament->qualification->finalists}}" min="4" max="12" required>
                </div>
            </div>
            <div class="form-group roundrobin">
                <h3>Round Robin</h3>
                <div class="form-group row">
                    <label for="rr-players" class="control-label col-md-6">Количество участников</label>
                    <input type="number" name="rr_players" id="rr-players" class="form-control col-md-6" value="{{$tournament->roundRobin->players}}"
                           min="0"
                           max="100" required>
                </div>
                <div class="form-group row">
                    <label for="rr-win-bonus" class="control-label col-md-6">Бонус за победу</label>
                    <input type="number" name="rr_win_bonus" id="rr-win-bonus" class="form-control col-md-6" value="{{$tournament->roundRobin->win_bonus}}"
                           min="15" max="25" required>
                </div>
                <div class="form-group row">
                    <label for="rr-draw-bonus" class="control-label col-md-6">Бонус за ничью</label>
                    <input type="number" name="rr_draw_bonus" id="rr-draw-bonus" class="form-control col-md-6"
                           value="{{$tournament->roundRobin->draw_bonus}}"
                           min="5" max="15" required>
                </div>
            </div>
        </div>

        <div class="creation-step">
            <h1>Квалификация</h1>
            <input type="hidden" id="squads-count" name="squads_count" value="{{$tournament->squads()->count()}}">
            <a href="#" id="add-squad" class="btn">добавить поток</a>
            @foreach($tournament->squads()->orderBy('date', 'ASC')->orderBy('start_time', 'ASC')->get() as $index => $squad)
            <div class="well">
                <h3>Поток {{$index + 1}}</h3>
                <input type="hidden" name="squad_id[]" value="{{$squad->id}}">
                <a href="#" class="remove-squad" onclick="removeSquad(this)"><span class="glyphicon glyphicon-remove remove"></span></a>
                <div class="form-group row">
                    <label class="control-label col-md-6" for="squad-date-{{$index}}">Дата проведения</label>
                    <input type="date" id="squad-date-{{$index}}" name="squad_date[]" class="form-control squad-date col-md-4"
                           pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"
                           title="Дата в формате гггг-мм-дд"
                           value="{{$squad->date}}">
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-6" for="squad-start-time-{{$index}}">Время начала</label>
                    <input type="time" id="squad-start-time-{{$index}}" name="squad_start_time[]"
                           class="form-control squad-start-time col-md-4"
                           pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм"
                           value="{{date('H:i', strtotime($squad->start_time))}}">
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-6" for="squad-end-time-{{$index}}">Время окончания</label>
                    <input type="time" id="squad-end-time-{{$index}}" name="squad_end_time[]"
                           class="form-control squad-end-time col-md-4"
                           pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм"
                           value="{{date('H:i', strtotime($squad->end_time))}}">
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-6" for="squad-max-players-{{$index}}">Количество участников</label>
                    <input type="number" id="squad-max-players-{{$index}}" name="squad_max_players[]"
                           class="form-control squad-max-players col-md-4" value="{{$squad->max_players}}" min="4"
                           max="50" required>
                </div>
            </div>
            @endforeach
            </div>

        <div class="creation-step">
            <h1>Стоимость участия и переигровки</h1>
            <div class="form-group row">
                <label for="qualification-fee" class="control-label col-md-6">Стоимость участия</label>
                <div class="input-group col-md-6">
                    <input type="text" id="qualification-fee" name="qualification_fee" class="form-control"
                           value="{{$tournament->qualification->fee}}" required>
                    <span class="input-group-addon">BYN</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-md-6">Переигровки</label>
                <div class="checkbox col-md-6">
                    <label><input type="checkbox" id="allow-reentry" name="allow_reentry" value="true"
                      @if ($tournament->qualification->allow_reentry)
                      checked
                      @endif
                      >разрешены</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="reentries-amount" class="control-label col-md-6">Количество переигровок</label>
                <input type="number" name="reentries_amount" id="reentries-amount" class="form-control col-md-6"
                       value="{{$tournament->qualification->reentries}}" min="1" max="4" required>
            </div>
            <div class="form-group row">
                <label for="reentry-fee" class="control-label col-md-6">Стоимость переигровки</label>
                <div class="input-group col-md-6">
                    <input type="text" id="reentry-fee" name="reentry_fee" class="form-control" value="{{$tournament->qualification->reentry_fee}}" required>
                    <span class="input-group-addon">BYN</span>
                </div>
            </div>
        </div>

        <div class="creation-step">
            <h1>Финал</h1>
            <div class="form-group row">
                <label for="rr-date" class="control-label col-md-6">Дата проведения</label>
                <input type="date" id="rr-date" name="rr_date" class="form-control col-md-6"
                       pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"
                       title="Дата в формате гггг-мм-дд"
                       value="{{$tournament->roundRobin->date}}">
            </div>
            <div class="form-group row">
                <label for="rr-start-time" class="control-label col-md-6">Время начала</label>
                <input type="time" id="rr-start-time" name="rr_start_time" class="form-control col-md-6"
                       pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм"
                       value="{{date('H:i', strtotime($tournament->roundRobin->start_time))}}">
            </div>
            <div class="form-group row">
                <label for="rr-end-time" class="control-label col-md-6">Время окончания</label>
                <input type="time" id="rr-end-time" name="rr_end_time" class="form-control col-md-6"
                       pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм"
                       value="{{date('H:i', strtotime($tournament->roundRobin->end_time))}}">
            </div>
        </div>

        <div class="creation-step">
            <h1>Контактная информация</h1>
            <div class="form-group row">
                <label for="contact-person" class="control-label col-md-6">Контактное лицо</label>
                <select class="form-control col-md-6" id="contact-person" name="contact_person">
                  @foreach ($admins as $admin)
                    <option value="{{$admin->id}}"
                      @if($tournament->contact->id == $admin->id)
                      selected
                      @endif
                      >{{$admin->name}} {{$admin->surname}}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label for="contact-phone" class="control-label col-md-6">Телефон</label>
                <input type="text" id="contact-phone" name="contact_phone" class="form-control col-md-6" required
                value="{{$tournament->contact->phone}}">
            </div>
            <div class="form-group row">
                <label for="contact-email" class="control-label col-md-6">Электронная почта</label>
                <input type="email" id="contact-email" name="contact_email" class="form-control col-md-6" required
                value="{{$tournament->contact->email}}">
            </div>
        </div>

        <div id="controls">
            <a href="/" id="cancel" class="btn cancel-btn">отмена</a>
            <button type="button" id="prev-step" class="btn" value="назад">назад</button>
            <input type="submit" id="save" class="btn" value="сохранить">
            <button type="button" id="next-step" class="btn" value="далее">далее</button>
        </div>
    </form>
@endsection

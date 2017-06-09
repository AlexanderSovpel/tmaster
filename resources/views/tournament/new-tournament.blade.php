@extends('layouts.app')
@section('content')
    <ol class="breadcrumb">
        <li><a href="/">Соревнования</a></li>
        <li>Создание турнира</li>
    </ol>
    {{--<div class="container">--}}
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
    {{--</div>--}}
    {{--<div id="error"></div>--}}
    <form method="post" action="/createTournament" id="new-tournament" class="panel panel-default">
        {{csrf_field()}}
        <input type="hidden" id="step" value="0">
        <div class="creation-step">
            <h1>Общая информация</h1>
            <div class="form-group row">
                <label for="name" class="control-label col-md-6">Название</label>
                <input type="text" name="name" id="name" class="form-control col-md-6" required>
            </div>
            <div class="form-group row">
                <label for="location" class="control-label col-md-6">Место проведения</label>
                <input type="text" name="location" id="location" class="form-control col-md-6" required>
            </div>
            <div class="form-group row">
                <label class="control-label col-md-6">Тип турнира</label>
                <div class="choose-type col-md-6">
                    <div class="radio">
                        <label><input type="radio" name="type" value="sport" checked>спортивный</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="type" value="commercial">коммерческий</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="oil-type" class="control-label col-md-6">Программа намазки</label>
                <!-- <div class="input-group"> -->
                <select class="form-control col-md-6" id="oil-type" name="oil_type">
                    <option value="короткая">короткая</option>
                    <option value="средняя" selected>средняя</option>
                    <option value="длинная">длинная</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="description" class="control-label col-md-6">Описание</label>
                <textarea name="description" id="description" class="form-control col-md-6" required></textarea>
            </div>
        </div>

        <div class="creation-step">
            <h1>Гандикап</h1>
            <div class="form-group row">
                <label for="handicap-type" class="control-label col-md-6">Правило начисления</label>
                <select class="form-control col-md-6" id="handicap-type" name="handicap_type">
                    <option value="средний">по среднему</option>
                    <option value="женский" selected>женский</option>
                    <option value="пожилой">пожилой</option>
                    <option value="детский">детский</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="handicap-value" class="control-label col-md-6">Значение</label>
                <input type="number" id="handicap-value" name="handicap_value" class="form-control col-md-6" value="8"
                       min="-30" max="30" required>
            </div>
            <div class="form-group row">
                <label for="handicap-max-game" class="control-label col-md-6">Максимальная игра</label>
                <input type="number" id="handicap-max-game" name="handicap_max_game" class="form-control col-md-6"
                       value="300" min="290" max="340" required>
            </div>
        </div>

        <div class="creation-step">
            <h1>Этапы соревнования</h1>
            <!-- <div id="qualification" class="form-group part-choice">
                <label>Отборочная часть</label>
                <div class="checkbox">
                    <label><input type="checkbox" name="qualification_part[]" value="has_qualification" checked
                        >квалификация</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="qualification_part[]"
                                  value="has_desperado">десперадо</label>
                </div>
            </div> -->
            <!-- <div id="final" class="form-group part-choice">
                <label>Финальная часть</label>
                <div class="checkbox">
                    <label><input type="checkbox" name="final_part[]" value="has_commonfinal"
                        >обычный</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="final_part[]" value="has_joinmatches">стыковочные
                        матчи</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="final_part[]" value="has_roundrobin" checked>round
                        robin</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="final_part[]" value="has_stepladder">step
                        ladder</label>
                </div>
            </div> -->
            <div class="form-group qualification">
                <h3>Квалификация</h3>
                <div class="form-group row">
                    <label for="qualification-games" class="control-label col-md-6">Количество блоков игр</label>
                    <input type="number" name="qualification_games" id="qualification-games"
                           class="form-control col-md-6"
                           value="1" min="1" max="5" required>
                </div>
                <div class="form-group row">
                    <label for="qualification-entries" class="control-label col-md-6">Количество игр в блоке</label>
                    <input type="number" name="qualification_entries" id="qualification-entries"
                           class="form-control col-md-6" value="6" min="3" max="10" required>
                </div>
                <div class="form-group row">
                    <label for="qualification-finalists" class="control-label col-md-6">Количество финалистов</label>
                    <input type="number" name="qualification_finalists" id="qualification-finalists"
                           class="form-control col-md-6" value="6" min="4" max="12" required>
                </div>
            </div>
            <!-- <div class="form-group desperado" hidden>
                <h3>Десперадо</h3>
                <div class="form-group">
                    <label for="desperado-games" class="">Количество блоков игр</label>
                    <input type="number" name="desperado_games" id="desperado-games" class="form-control" value="1"
                           min="1" max="5">
                </div>
                <div class="form-group">
                    <label for="desperado-entries" class="">Количество игр в блоке</label>
                    <input type="number" name="desperado_entries" id="desperado-entries" class="form-control"
                           value="1" min="1" max="5">
                </div>
                <div class="form-group">
                    <label for="desperado-finalists" class="">Количество финалистов</label>
                    <input type="number" name="desperado_finalists" id="desperado-finalists" class="form-control"
                           value="2" min="1" max="4">
                </div>
            </div>
            <div class="form-group commonfinal" hidden>
                <h3>Обычный финал</h3>
                <div class="form-group">
                    <label for="commonfinal-players" class="">Количество участников</label>
                    <input type="number" name="commonfinal_players" id="commonfinal-players" class="form-control"
                           value="6" min="4" max="12">
                </div>
                <div class="form-group">
                    <label for="commonfinal-games" class="">Количество блоков игр</label>
                    <input type="number" name="commonfinal_games" id="commonfinal-games" class="form-control"
                           value="1" min="1" max="5">
                </div>
                <div class="form-group">
                    <label for="commonfinal-entries" class="">Количество игр в блоке</label>
                    <input type="number" name="commonfinal_entries" id="commonfinal-entries" class="form-control"
                           value="1" min="1" max="5">
                </div>
            </div>
            <div class="form-group joinmatches" hidden>
                <h3>Стыковочные матчи</h3>
                <a href="#">добавить</a>
                <div class="form-group">
                    <label for="joinmatches-games" class="">Количество блоков игр</label>
                    <input type="number" name="joinmatches_games" id="joinmatches-games" class="form-control"
                           value="1" min="1" max="5">
                </div>
                <div class="form-group">
                    <label for="joinmatches-entries" class="">Количество игр в блоке</label>
                    <input type="number" name="joinmatches_entries" id="joinmatches-entries" class="form-control"
                           value="2" min="1" max="5">
                </div>
                <div class="joinmatch well">
                    <label>Финал 1</label>
                    <a href="#"><span class="glyphicon glyphicon-remove remove"></span></a>
                    <div class="form-group">
                        <label>Участвуют места</label>
                        <div class="input-group">
                            <input type="text" name="joinmatch1-from" class="form-control" value="5">
                            <span class="input-group-addon">-</span>
                            <input type="text" name="joinmatch1-to" class="form-control" value="12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="joinmatch1-finalists" class="">Количество финалистов</label>
                        <input type="number" name="joinmatch1_finalists" id="joinmatch1-finalists"
                               class="form-control" value="4" min="1" max="6">
                    </div>
                </div>
                <div class="joinmatch well">
                    <label>Финал 2</label>
                    <a href="#"><span class="glyphicon glyphicon-remove remove"></span></a>
                    <div class="form-group">
                        <label>Участвуют места</label>
                        <div class="input-group">
                            <input type="text" name="joinmatch2-from" class="form-control" value="1">
                            <span class="input-group-addon">-</span>
                            <input type="text" name="joinmatch2-to" class="form-control" value="4">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="joinmatch2-finalists" class="">Количество финалистов</label>
                        <input type="number" name="joinmatch2_finalists" id="joinmatch2-finalists"
                               class="form-control" value="4" min="1" max="6">
                    </div>
                </div>
            </div> -->
            <div class="form-group roundrobin">
                <h3>Round Robin</h3>
                <div class="form-group row">
                    <label for="rr-players" class="control-label col-md-6">Количество участников</label>
                    <input type="number" name="rr_players" id="rr-players" class="form-control col-md-6" value="6"
                           min="4"
                           max="12" required>
                </div>
                <div class="form-group row">
                    <label for="rr-win-bonus" class="control-label col-md-6">Бонус за победу</label>
                    <input type="number" name="rr_win_bonus" id="rr-win-bonus" class="form-control col-md-6" value="20"
                           min="15" max="25" required>
                </div>
                <div class="form-group row">
                    <label for="rr-draw-bonus" class="control-label col-md-6">Бонус за ничью</label>
                    <input type="number" name="rr_draw_bonus" id="rr-draw-bonus" class="form-control col-md-6"
                           value="10"
                           min="5" max="15" required>
                </div>
            </div>
        </div>

        <div class="creation-step">
            <h1>Квалификация</h1>
            <input type="hidden" id="squads-count" name="squads_count" value="2">
            <a href="#" id="add-squad" class="btn">добавить поток</a>
            @include('partial.squad-form', ['index' => 2])
            @include('partial.squad-form', ['index' => 1])
        </div>

        <div class="creation-step">
            <h1>Стоимость участия и переигровки</h1>
            {{--<div class="form-group">--}}
            {{--<h3>Квалификация</h3>--}}
            <div class="form-group row">
                <label for="qualification-fee" class="control-label col-md-6">Стоимость участия</label>
                <div class="input-group col-md-6">
                    <input type="text" id="qualification-fee" name="qualification_fee" class="form-control"
                           value="50" required>
                    <span class="input-group-addon">BYN</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-md-6">Переигровки</label>
                <div class="checkbox col-md-6">
                    <label><input type="checkbox" id="allow-reentry" name="allow_reentry" value="true" checked>разрешены</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="reentries-amount" class="control-label col-md-6">Количество переигровок</label>
                <input type="number" name="reentries_amount" id="reentries-amount" class="form-control col-md-6"
                       value="1" min="1" max="4" required>
            </div>
            <div class="form-group row">
                <label for="reentry-fee" class="control-label col-md-6">Стоимость переигровки</label>
                <div class="input-group col-md-6">
                    <input type="text" id="reentry-fee" name="reentry_fee" class="form-control" value="60" required>
                    <span class="input-group-addon">BYN</span>
                </div>
            </div>
            {{--</div>--}}
        </div>

        <div class="creation-step">
            <h1>Финал</h1>
            {{--<div class="form-group">--}}
            {{--<h3>Round Robin</h3>--}}
            <div class="form-group row">
                <label for="rr-date" class="control-label col-md-6">Дата проведения</label>
                <input type="date" id="rr-date" name="rr_date" class="form-control col-md-6"
                       pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"
                       title="Дата в формате гггг-мм-дд">
            </div>
            <div class="form-group row">
                <label for="rr-start-time" class="control-label col-md-6">Время начала</label>
                <input type="date" id="rr-start-time" name="rr_start_time" class="form-control col-md-6"
                       pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм">
            </div>
            <div class="form-group row">
                <label for="rr-end-time" class="control-label col-md-6">Время окончания</label>
                <input type="date" id="rr-end-time" name="rr_end_time" class="form-control col-md-6"
                       pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм">
            </div>
            {{--</div>--}}
        </div>

        <div class="creation-step">
            <h1>Контактная информация</h1>
            <div class="form-group row">
                <label for="contact-person" class="control-label col-md-6">Контактное лицо</label>
                <select class="form-control col-md-6" id="contact-person" name="contact_person">
                  <!-- @foreach ($admins as $admin)
                    <option value="{{$admin->id}}">{{$admin->name $admin->surname}}</option>
                  @endforeach -->
                </select>
                <!-- <input type="text" id="contact-person" name="contact_person" class="form-control col-md-6" required> -->
            </div>
            <div class="form-group row">
                <label for="contact-phone" class="control-label col-md-6">Телефон</label>
                <input type="text" id="contact-phone" name="contact_phone" class="form-control col-md-6" readonly>
            </div>
            <div class="form-group row">
                <label for="contact-email" class="control-label col-md-6">Электронная почта</label>
                <input type="email" id="contact-email" name="contact_email" class="form-control col-md-6" readonly>
            </div>
        </div>

        <div id="controls">
            <button type="button" id="prev-step" class="btn" value="назад">назад</button>
            <button type="button" id="next-step" class="btn" value="далее">далее</button>
            <input type="submit" id="save" class="btn" value="сохранить">
        </div>
    </form>
    <div id="error"></div>
@endsection

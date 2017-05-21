@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="/saveTournament" id="new-tournament">
            {{csrf_field()}}
            <input type="hidden" id="step" value="0">
            <div class="creation-step">
                <h2>Общая информация</h2>
                <div class="form-group">
                    <label for="name" class="">Название</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="location" class="">Место проведения</label>
                    <input type="text" name="location" id="location" class="form-control">
                </div>
                <div class="form-group">
                    <label>Тип турнира</label>
                    <div class="radio">
                        <label><input type="radio" name="type" value="sport" checked>спортивный</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="type" value="commercial">коммерческий</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="oil-type">Программа намазки</label>
                    <div class="input-group">
                        <select class="form-control" id="oil-type" name="oil_type">
                            <option value="short">короткая</option>
                            <option value="middle" selected>средняя</option>
                            <option value="long">длинная</option>
                        </select>
                        <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button">
                            <span class="glyphicon glyphicon-file"></span>
                        </button>
                    </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
            </div>

            <div class="creation-step">
                <h2>Гандикап</h2>
                <div class="form-group">
                    <label for="handicap-type">Правило начисления</label>
                    <select class="form-control" id="handicap-type" name="handicap_type">
                        <option value="средний">по среднему</option>
                        <option value="женский" selected>женский</option>
                        <option value="пожилой">пожилой</option>
                        <option value="детский">детский</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="handicap-value">Значение</label>
                    <input type="number" id="handicap-value" name="handicap_value" class="form-control" value="8"
                           min="-30" max="30">
                </div>
                <div class="form-group">
                    <label for="handicap-max-game">Максимальная игра</label>
                    <input type="number" id="handicap-max-game" name="handicap_max_game" class="form-control"
                           value="300" min="290" max="340">
                </div>
            </div>

            <div class="creation-step">
                <h2>Этапы соревнования</h2>
                <div id="qualification" class="form-group part-choice">
                    <label>Отборочная часть</label>
                    <div class="checkbox">
                        <label><input type="checkbox" name="qualification_part[]" value="has_qualification" checked
                            >квалификация</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="qualification_part[]"
                                      value="has_desperado">десперадо</label>
                    </div>
                </div>
                <div id="final" class="form-group part-choice">
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
                </div>
                <div class="form-group qualification">
                    <h3>Квалификация</h3>
                    <div class="form-group">
                        <label for="qualification-games" class="">Количество блоков игр</label>
                        <input type="number" name="qualification_games" id="qualification-games" class="form-control"
                               value="1" min="1" max="5">
                    </div>
                    <div class="form-group">
                        <label for="qualification-entries" class="">Количество игр в блоке</label>
                        <input type="number" name="qualification_entries" id="qualification-entries"
                               class="form-control" value="6" min="3" max="10">
                    </div>
                    <div class="form-group">
                        <label for="qualification-finalists" class="">Количество финалистов</label>
                        <input type="number" name="qualification_finalists" id="qualification-finalists"
                               class="form-control" value="6" min="4" max="12">
                    </div>
                </div>
                <div class="form-group desperado" hidden>
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
                </div>
                <div class="form-group roundrobin">
                    <h3>Round Robin</h3>
                    <div class="form-group">
                        <label for="rr-players" class="">Количество участников</label>
                        <input type="number" name="rr_players" id="rr-players" class="form-control" value="6" min="4"
                               max="12">
                    </div>
                    <div class="form-group">
                        <label for="rr-win-bonus" class="">Бонус за победу</label>
                        <input type="number" name="rr_win_bonus" id="rr-win-bonus" class="form-control" value="20"
                               min="15" max="25">
                    </div>
                    <div class="form-group">
                        <label for="rr-draw-bonus" class="">Бонус за ничью</label>
                        <input type="number" name="rr_draw_bonus" id="rr-draw-bonus" class="form-control" value="10"
                               min="5" max="15">
                    </div>
                </div>
            </div>

            <div class="creation-step">
                <h2>Квалификация</h2>
                <label>Потоки квалификации</label>
                <input type="hidden" id="squads-count" name="squads_count" value="2">
                <a href="#" id="add-squad">добавить</a>
                @include('partial.squad-form', ['index' => 2])
                @include('partial.squad-form', ['index' => 1])
            </div>

            <div class="creation-step">
                <h2>Стоимость участия и переигровки</h2>
                <div class="form-group">
                    <h3>Квалификация</h3>
                    <div class="form-group">
                        <label for="qualification-fee">Стоимость участия</label>
                        <div class="input-group">
                            <input type="text" id="qualification-fee" name="qualification_fee" class="form-control"
                                   value="50">
                            <span class="input-group-addon">BYN</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Переигровки</label>
                        <div class="checkbox">
                            <label><input type="checkbox" id="allow-reentry" name="allow_reentry" value="true" checked>разрешены</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reentries-amount" class="">Количество переигровок</label>
                        <input type="number" name="reentries_amount" id="reentries-amount" class="form-control"
                               value="1" min="1" max="4">
                    </div>
                    <div class="form-group">
                        <label for="reentry-fee">Стоимость переигровки</label>
                        <div class="input-group">
                            <input type="text" id="reentry-fee" name="reentry_fee" class="form-control" value="60">
                            <span class="input-group-addon">BYN</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="creation-step">
                <h2>Финал</h2>
                <div class="form-group">
                    <h3>Round Robin</h3>
                    <div class="form-group">
                        <label for="rr-date">Дата проведения</label>
                        <input type="date" id="rr-date" name="rr_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="rr-start-time">Время начала</label>
                        <input type="date" id="rr-start-time" name="rr_start_time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="rr-end-time">Время окончания</label>
                        <input type="date" id="rr-end-time" name="rr_end_time" class="form-control">
                    </div>
                </div>
            </div>

            <div class="creation-step">
                <h2>Контактная информация</h2>
                <div class="form-group">
                    <label for="contact-person">Контактное лицо</label>
                    <input type="text" id="contact-person" name="contact_person" class="form-control">
                </div>
                <div class="form-group">
                    <label for="contact-phone">Телефон</label>
                    <input type="text" id="contact-phone" name="contact_phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="contact-email">Электронная почта</label>
                    <input type="email" id="contact-email" name="contact_email" class="form-control">
                </div>
            </div>

            <div id="controls">
                <button type="button" id="prev-step" class="btn" value="назад">назад</button>
                <button type="button" id="next-step" class="btn" value="далее">далее</button>
                <input type="submit" id="save" class="btn" value="сохранить">
            </div>
        </form>
        <div id="error"></div>
    </div>
@endsection
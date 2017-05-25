<div class="well">
    <h3>Поток {{$index}}</h3>
    <a href="#" class="remove-squad" onclick="removeSquad(this)"><span class="glyphicon glyphicon-remove remove"></span></a>
    <div class="form-group">
        <label>Дата проведения
            <input type="date" name="squad_date[]" class="form-control squad-date" pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"
            title="Дата в формате гггг-мм-дд">
        </label>
    </div>
    <div class="form-group">
        <label>Время начала
            <input type="date" name="squad_start_time[]" class="form-control squad-start-time" pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм">
        </label>
    </div>
    <div class="form-group">
        <label>Время окончания
            <input type="date" name="squad_end_time[]" class="form-control squad-end-time" pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм">
        </label>
    </div>
    <div class="form-group">
        <label>Количество участников
            <input type="number" name="squad_max_players[]" class="form-control squad-max-players" value="8" min="6"
                   max="12" required>
        </label>
    </div>
</div>

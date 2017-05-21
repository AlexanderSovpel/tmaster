<div class="form-group well squad">
    <label>Поток {{$index}}</label>
    <a href="#" class="remove-squad" onclick="removeSquad(this)"><span class="glyphicon glyphicon-remove remove"></span></a>
    <div class="form-group">
        <label>Дата проведения
            <input type="date" name="squad_date[]" class="form-control squad-date">
        </label>
    </div>
    <div class="form-group">
        <label>Время начала
            <input type="date" name="squad_start_time[]" class="form-control squad-start-time">
        </label>
    </div>
    <div class="form-group">
        <label>Время окончания
            <input type="date" name="squad_end_time[]" class="form-control squad-end-time">
        </label>
    </div>
    <div class="form-group">
        <label>Количество участников
            <input type="number" name="squad_max_players[]" class="form-control squad-max-players" value="8" min="6"
                   max="12">
        </label>
    </div>
</div>
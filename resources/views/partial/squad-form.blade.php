<div class="well">
    <h3>Поток {{$index}}</h3>
    <input type="hidden" name="squad_id[]" value="">
    <a href="#" class="remove-squad" onclick="removeSquad(this)"><span class="glyphicon glyphicon-remove remove"></span></a>
    <div class="form-group row">
        <label class="control-label col-md-6" for="squad-date-{{$index}}">Дата проведения</label>
        <input type="date" id="squad-date-{{$index}}" name="squad_date[]" class="form-control squad-date col-md-4"
               pattern="^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"
               title="Дата в формате гггг-мм-дд">
    </div>
    <div class="form-group row">
        <label class="control-label col-md-6" for="squad-start-time-{{$index}}">Время начала</label>
        <input type="time" id="squad-start-time-{{$index}}" name="squad_start_time[]"
               class="form-control squad-start-time col-md-4"
               pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм">
    </div>
    <div class="form-group row">
        <label class="control-label col-md-6" for="squad-end-time-{{$index}}">Время окончания</label>
        <input type="time" id="squad-end-time-{{$index}}" name="squad_end_time[]"
               class="form-control squad-end-time col-md-4"
               pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" title="Время в формате чч:мм">
    </div>
    <div class="form-group row">
        <label class="control-label col-md-6" for="squad-max-players-{{$index}}">Количество участников</label>
        <input type="number" id="squad-max-players-{{$index}}" name="squad_max_players[]"
               class="form-control squad-max-players col-md-4" value="8" min="4"
               max="50" required>
    </div>
</div>

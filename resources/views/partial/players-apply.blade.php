<div id="popup">
  <div id="popup-content">
    <a class="close" title="Закрыть" href="#" id="close-apply" onclick="closeApply()"><span class="glyphicon glyphicon-remove"></span></a>
      <input type="hidden" value="{{$squadId}}" name="squad_id" id="apply-squad">
      <div class="form-group row choose-player">
          <label for="player-select" class="control-label col-md-4">Игрок</label>
          <select class="form-control col-md-4" id="player-select" name="player_id">
            @foreach($players as $player)
            <option value="{{$player->id}}">{{$player->surname}} {{$player->name}}</option>
            @endforeach
          </select>
      </div>
      <button type="submit" class="btn add-player-btn" id="send-application" onclick="sendApplication()">добавить</button>
      <div class="clearfix"></div>
  </div>
</div>

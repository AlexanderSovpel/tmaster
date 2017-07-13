@extends('layouts.app')
@section('content')
  @include('partial.breadcrumb', ['page' => 'Результаты'])
  <ul class="nav nav-tabs" id="result-tabs">
      @if($tournament->squads->count() > 1)
      @foreach($tournament->squads as $index => $squad)
      <li role="presentation" class="result-tab">
          <a href="#" id="show-squad-{{$squad->id}}-results">Поток {{$index + 1}}</a>
      </li>
      @endforeach
      @endif
      <li role="presentation" class="active result-tab">
          <a href="#" id="show-qualification-results">Квалификация</a>
      </li>
      @if ($tournament->roundRobin->players)
      <li role="presentation" class="result-tab">
          <a href="#" id="show-final-results">Финал</a>
      </li>
      @endif
      <li role="presentation" class="result-tab">
          <a href="#" id="show-all-results" >Итоги</a>
      </li>
  </ul>
  <div id="results">
      @if($tournament->squads->count() > 1)
      @foreach($tournament->squads as $squad)
      <div id="squad-{{$squad->id}}-results" class="result-table" hidden>
          @include('partial.squad-results', ['squadId' => $squad->id])
      </div>
      @endforeach
      @endif
      <div id="qualification-results" class="result-table">
          @include('partial.qualification-results')
      </div>
      @if ($tournament->roundRobin->players)
      <div id="final-results" class="result-table" hidden>
          @include('partial.final-results')
      </div>
      @endif
      <div id="all-results" class="result-table" hidden>
          @include('partial.all-results')
      </div>
  </div>

  <div class="modal fade" id="changeResult" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Изменение результата игры</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="game-id">
          <input type="text" id="game-result" class="form-control">
          <input type="text" id="game-bonus" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn cancel-btn" data-dismiss="modal">Отменить</button>
          <button type="submit" class="btn" data-dismiss="modal" id="save-result">Сохранить</button>
        </div>
      </div>
    </div>
  </div>
@endsection

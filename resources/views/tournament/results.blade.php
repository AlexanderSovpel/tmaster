@extends('layouts.app')
@section('content')
@include('partial.breadcrumb', ['page' => 'Результаты'])
        <ul class="nav nav-tabs" id="result-tabs">
            <li role="presentation" class="active">
                <a href="#" id="show-qualification-results">Квалификация</a>
            </li>
            @if ($tournament->roundRobin->players)
            <li role="presentation" >
                <a href="#" id="show-final-results">Финал</a>
            </li>
            @endif
            <li role="presentation" >
                <a href="#" id="show-all-results" >Итоги</a>
            </li>
        </ul>
        <div id="results">
            <div id="qualification-results" >
                @include('partial.qualification-results')
            </div>
            @if ($tournament->roundRobin->players)
            <div id="final-results" hidden>
                @include('partial.final-results')
            </div>
            @endif
            <div id="all-results" hidden>
                @include('partial.all-results')
            </div>
        </div>
@endsection

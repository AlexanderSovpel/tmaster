@extends('layouts.app')
@section('content')
@include('partial.breadcrumb', ['page' => 'Результаты'])
    <!-- <section class="container"> -->
        <ul class="nav nav-tabs" id="result-tabs">
            @foreach($squads as $index => $squad)
            <li role="presentation" class="">
                <a href="#" id="show-squad-{{$index}}-results">Поток {{$index + 1}}</a>
            </li>
            @endforeach
            <li role="presentation" class="active">
                <a href="#" id="show-qualification-results">Квалификация</a>
            </li>
            @if ($tournament->roundRobin->players)
            <li role="presentation" class="">
                <a href="#" id="show-final-results">Финал</a>
            </li>
            @endif
            <li role="presentation" class="">
                <a href="#" id="show-all-results" >Итоги</a>
            </li>
        </ul>
        <div id="results">
            @foreach($squads as $index => $squad)
            <div id="squad-{{$index}}-results">
                @include('partial.squad-results', ['squad' => $squad])
            </div>
            @endforeach
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
    <!-- </section> -->
@endsection

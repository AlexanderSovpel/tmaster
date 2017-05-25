@extends('layouts.app')
@section('content')
@include('partial.breadcrumb', ['page' => 'Результаты'])
    <!-- <section class="container"> -->
        <ul class="nav nav-tabs" id="result-tabs">
            <li role="presentation">
                <a href="#" id="show-qualification-results">Квалификация</a>
            </li>
            <li role="presentation" >
                <a href="#" id="show-final-results">Финал</a>
            </li>
            <li role="presentation" class="active">
                <a href="#" id="show-all-results" >Итоги</a>
            </li>
        </ul>
        <div id="results">
            <div id="qualification-results" hidden>
                @include('partial.qualification-results')
            </div>
            <div id="final-results" hidden>
                @include('partial.final-results')
            </div>
            <div id="all-results" >
                @include('partial.all-results')
            </div>
        </div>
    <!-- </section> -->
@endsection

@extends('layouts.app')

@section('content')
    <section class="container">
        @if($user->is_admin)
            <a href="/newTournament" class="add-tournament-btn">добавить соревнование</a>
        @endif
        @foreach($tournaments as $tournament)
            @include('partial.tournament')
        @endforeach
    </section>
@endsection

@extends('layouts.app')

@section('content')
        @if(\Illuminate\Support\Facades\Auth::check() && $user->is_admin)
            <a href="/newTournament" class="add-tournament-btn">добавить соревнование</a>
        @endif
        @foreach($tournaments as $tournament)
            @include('partial.tournament')
        @endforeach
@endsection

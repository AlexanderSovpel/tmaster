@extends('layouts.app')

@section('content')
        @if($user->is_admin)
            <a href="/newTournament" class="add-tournament-btn">добавить соревнование</a>
        @endif
        @foreach($tournaments as $tournament)
            @include('partial.tournament')
        @endforeach
        <div class="pagination-center">
          {{$tournaments->links()}}
        </div>
@endsection

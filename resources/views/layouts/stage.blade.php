@section('stage')
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li
                    @if($stage == 'conf')
                    class="active"
                    @else
                    class=""
                    @endif
            ><a href="#">подтверждение</a></li>

            <li
                    @if($stage == 'draw')
                    class="active"
                    @else
                    class=""
                    @endif
            ><a href="#">жеребьёвка</a></li>

            <li
                    @if($stage == 'game')
                    class="active"
                    @else
                    class=""
                    @endif
            ><a href="#">игра</a></li>

            <li
                    @if($stage == 'rest')
                    class="active"
                    @else
                    class=""
                    @endif
            ><a href="#">результаты</a></li>
        </ul>
    </nav>
@endsection
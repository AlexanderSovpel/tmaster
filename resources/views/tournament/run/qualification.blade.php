<h2>Квалификация - Результаты</h2>
<form action="/{{$tournament->id}}/run/rr/conf/" method="post">
    {{ csrf_field() }}
    @foreach($playerResult as $result)
        <p>
            {{array_search($result, $playerResult)}}
            {{$result}}
        </p>
    @endforeach
    <button type="submit">начать финал</button>
</form>

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Редактирование профиля</h2>
        <form method="post" action="/account/save" id="new-tournament">
            {{csrf_field()}}
            <input type="hidden" value="{{$user->id}}" name="id">
            <div class="form-group">
                <label for="name" class="">Имя</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}">
            </div>
            <div class="form-group">
                <label for="surname" class="">Фамилия</label>
                <input type="text" name="surname" id="surname" class="form-control" value="{{$user->surname}}">
            </div>
            <div class="form-group">
                <label>Пол</label>
                <div class="radio">
                    <label><input type="radio" name="gender"
                                  value="мужской" {{($user->gender == 'мужской') ? 'checked' : ''}}>мужской</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="gender"
                                  value="женский" {{($user->gender == 'женский') ? 'checked' : ''}}>женский</label>
                </div>
            </div>
            <div class="form-group">
                <label for="birthday" class="">Дата рождения</label>
                <input type="date" name="birthday" id="birthday" class="form-control" value="{{$user->birthday}}">
            </div>
            <div class="form-group">
                <label for="phone" class="">Телефон</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{$user->phone}}">
            </div>
            <div class="form-group">
                <label for="email" class="">Электронная почта</label>
                <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}">
            </div>
            <button type="submit" class="btn">Сохранить</button>
        </form>
        <div id="error"></div>
    </div>
@endsection
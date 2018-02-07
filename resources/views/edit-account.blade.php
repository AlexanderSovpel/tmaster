@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/{{$user->id}}/account">{{$user->name}} {{$user->surname}}</a></li>
        <li>Редактирование профиля</li>
    </ol>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Редактирование профиля</h1></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/account/save"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="name" class="col-md-6 control-label">Имя</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name"
                                       value="{{ $user->name }}" required autofocus>
                            </div>
                        </div>

                <div class="form-group">
                    <label for="surname" class="col-md-4 control-label">Фамилия</label>
                    <div class="col-md-8">
                        <input id="surname" type="text" class="form-control" name="surname"
                               value="{{ $user->surname }}" required autofocus>
                    </div>
                </div>

                        <div class="form-group">
                            <label for="birthday" class="col-md-6 control-label">Изображение профиля</label>
                            <div class="col-md-6">
                                <input id="avatar" type="file" name="avatar" class="form-control avatar-file"
                                       accept="image/jpeg, image/png, image/gif">
                                <label for="avatar"><span class="glyphicon glyphicon-file"></span> {{($user->avatar) ? $user->avatar : 'Выберите изображение'}}</label>
                            </div>
                        </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Пол</label>
                    <div class="col-md-8">
                        <label>
                            <input type="radio" name="gender"
                                   value="мужской" {{($user->gender == 'мужской') ? 'checked' : ''}}>мужской
                        </label>
                    </div>
                    <div class="col-md-8">
                        <label>
                            <input type="radio" name="gender"
                                   value="женский" {{($user->gender == 'женский') ? 'checked' : ''}}>женский
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="birthday" class="col-md-4 control-label">Дата рождения</label>
                    <div class="col-md-8">
                        <input id="birthday" type="date" name="birthday" class="form-control"
                               value="{{$user->birthday}}">
                    </div>
                </div>

                        <div class="form-group">
                            <label for="email" class="col-md-6 control-label">Телефон</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone"
                                       value="{{ $user->phone }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-6 control-label">Электронная почта</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ $user->email }}" required>
                            </div>
                        </div>

                        <h3>Изменение пароля</h3>

                        <div class="form-group">
                            <label for="old-password" class="col-md-6 control-label">Старый пароль</label>
                            <div class="col-md-6">
                                <input id="old-password" type="password" class="form-control" name="old_password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new-password" class="col-md-6 control-label">Новый пароль</label>
                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control" name="new_password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-6 control-label">Подтверждение пароля</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirm">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <a href="/{{$user->id}}/account" class="btn cancel-btn">Отменить</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn save-btn">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/account.js') }}"></script>
@endsection
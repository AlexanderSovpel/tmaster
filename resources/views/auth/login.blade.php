@extends('layouts.app')

@section('content')
<div class="panel panel-default login-panel">
    <div class="panel-heading"><h1>Вход</h1></div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                <label for="email" class="col-md-4 control-label">Электронная почта</label>

                <div class="col-md-8">
                    <input id="email" type="email" class="form-control" name="email"
                           value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                <label for="password" class="col-md-4 control-label">Пароль</label>

                <div class="col-md-8">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input id="checkbox" type="checkbox" name="remember"
                            {{ old('remember') ? 'checked' : '' }}> Запомнить меня
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
              <button type="submit" class="btn col-md-3 col-md-offset-4">Вход</button>
              <a class="btn btn-link col-md-4" href="{{ route('password.request') }}">
                  Забыли пароль?
              </a>
            </div>
        </form>
    </div>
</div>
@endsection

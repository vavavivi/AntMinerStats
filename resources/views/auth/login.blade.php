@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <i class="fa fa-envira fa-2x"></i>
                <br>
                <a href="{{ url('/home') }}">AntSTATS <sup>1.0</sup></a>
            </div>

            <form method="post" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email адрес">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Пароль" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                    @endif

                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="checkbox pull-left">
                            <label>
                                <input type="checkbox" name="remember"> Запомни меня
                            </label>
                        </div>
                        <a class="btn btn-sm btn-default btn-flat pull-right" href="{{ url('/password/reset') }}" style="margin-left: 5px; margin-top: 5px;">Забыл пароль</a>
                        <button type="submit" class="btn btn-sm btn-primary btn-flat  pull-right" style="margin-left: 5px;  margin-top: 5px;">Вход &rarr;</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
    </div>
@endsection

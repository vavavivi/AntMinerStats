@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <img src="/images/antstats-logo-bw.png"><br>
                <a href="{{ url('/home') }}">{!! env('APP_FULL_NAME') !!}</a><br>
                <p class="text-center">Real time monitoring system</p>
            </div>



            <form method="post" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control input-sm" name="email" value="{{ old('email') }}" placeholder="user@domain.com">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control input-sm" placeholder="Password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-sm btn-primary btn-flat" style="margin-top: 5px;"><i class="fa fa-sign-in"></i> Login</button>
                        <a class="btn btn-sm btn-warning btn-flat" href="{{ url('/password/reset') }}" style="margin-left: 5px; margin-top: 5px;">Forgot password</a>
                        <a class="btn btn-sm btn-danger btn-flat pull-right" href="{{ url('/register') }}" style="margin-left: 5px; margin-top: 5px;"><i class="fa fa-user-plus"></i> Register</a>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12">

                </div>
            </div>

        </div>
    </div>
@endsection

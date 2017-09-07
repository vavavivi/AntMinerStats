@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <img src="/images/antstats-logo-bw.png">
                <br>
                <a href="{{ url('/home') }}">{!! env('APP_FULL_NAME') !!}</a>
            </div>

            <form method="post" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="user@domain.com">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Password" name="password">
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
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                        </div>
                        <a class="btn btn-sm btn-default btn-flat pull-right" href="{{ url('/password/reset') }}" style="margin-left: 5px; margin-top: 5px;">Forgot password</a>
                        <button type="submit" class="btn btn-sm btn-primary btn-flat  pull-right" style="margin-left: 5px;  margin-top: 5px;">Login</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <a class="pull-right" href="{{ url('/register') }}" style="margin-left: 5px; margin-top: 5px;">Dont have account ? Register!</a>
                </div>
            </div>

        </div>
    </div>
@endsection

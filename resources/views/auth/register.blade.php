@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <img src="/images/antstats-logo-bw.png"><br>
                <a href="{{ url('/home') }}">{!! env('APP_FULL_NAME') !!}</a><br>
                <p class="text-center">Real time monitoring system</p>
            </div>

            <form  method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="Username" name="name" value="{{ old('name') }}" required autofocus>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" required>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-6 text-left">
                        <a href="/login/" class="btn btn-default btn-flat btn-sm">&larr; Back to Login</a>
                    </div>
                    <div class="col-xs-6 text-right">
                        <button type="submit" class="btn btn-primary btn-flat btn-sm">Register new user &rarr;</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

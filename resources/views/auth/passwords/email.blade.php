@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <img src="/images/antstats-logo-bw.png"><br>
                <a href="{{ url('/home') }}">{!! env('APP_FULL_NAME') !!}</a><br>
                <p class="text-center">Real time monitoring system</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="row>">
                    <div class="col-sm-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">Enter your e-mail address:</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-sm-12 form-group text-center">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Send Password Reset Link
                        </button>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>

@endsection

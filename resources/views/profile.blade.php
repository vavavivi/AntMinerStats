@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Ant Miner
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model(Auth::user(), ['route' => ['profile'], 'method' => 'POST']) !!}
                        <div class="form-group col-sm-6 {{$errors->has('name') ? 'has-error' : ''}}">
                            {!! Form::label('name', 'Username:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-6 {{$errors->has('email') ? 'has-error' : ''}}">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-6 {{$errors->has('chat_id') ? 'has-error' : ''}}">
                            {!! Form::label('chat_id', 'Telegram Chat ID:') !!}
                            {!! Form::text('chat_id', null, ['class' => 'form-control']) !!}

                            @if ($errors->has('chat_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('chat_id') }}</strong>
                                </span>
                            @else
                                <span class="help-block">
                                <p>To get your chat ID for telegram notifications please say hello to <a href="https://telegram.me/AntMinerNotify_bot" target="_blank">@AntMinerNotify_bot</a></p>
                            </span>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        <!-- Password Field -->
                        <div class="form-group col-sm-6 {{$errors->has('password') ? 'has-error' : ''}}">
                            {!! Form::label('password', 'New Password:') !!}
                            {!! Form::password('password', ['class' => 'form-control','autocomplete'=>'new-password']) !!}
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('home') !!}" class="btn btn-default">Cancel</a>
                        </div>

                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

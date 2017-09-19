<!-- Title Field -->
<div class="form-group col-sm-6 {{ $errors->has('title') ? ' has-error' : '' }}">
    {!! Form::label('title', '* Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','placeholder' => 'My Antminer S9']) !!}
    @if ($errors->has('title'))
        <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
    @endif
</div>

<!-- Type Field -->
<div class="form-group col-sm-6 {{ $errors->has('type') ? ' has-error' : '' }}">
    {!! Form::label('type', '* Type:') !!}
    {!! Form::select('type',[null => 'Select ASIC Type','bmminer' => 'AntMiner T9/S9','cgminer' => 'AntMiner S7'], null, ['class' => 'form-control']) !!}
    @if ($errors->has('type'))
        <span class="help-block"><strong>{{ $errors->first('type') }}</strong></span>
    @endif
</div>

<div class="clearfix"></div>

<!-- Host Field -->
<div class="form-group col-sm-6 {{ $errors->has('host') ? ' has-error' : '' }}">
    {!! Form::label('host', '* Host (accepts both IP and hostmane):') !!}
    {!! Form::text('host', null, ['class' => 'form-control','placeholder' => '100.84.213.43']) !!}
    @if ($errors->has('host'))
        <span class="help-block"><strong>{{ $errors->first('host') }}</strong></span>
    @endif
</div>

<!-- Port Field -->
<div class="form-group col-sm-6 {{ $errors->has('port') ? ' has-error' : '' }}">
    {!! Form::label('port', '* API Port:') !!}
    {!! Form::text('port', null, ['class' => 'form-control','placeholder' => '4028']) !!}
    @if ($errors->has('port'))
        <span class="help-block"><strong>{{ $errors->first('port') }}</strong></span>
    @endif
</div>

<div class="clearfix"></div>

<!-- temp_limit Field -->
<div class="form-group col-sm-6 {{ $errors->has('temp_limit') ? ' has-error' : '' }}">
    {!! Form::label('temp_limit', 'Temperature warning level (in Celsius):') !!}
    {!! Form::text('temp_limit', null, ['class' => 'form-control','placeholder' => '85']) !!}
    @if ($errors->has('temp_limit'))
        <span class="help-block"><strong>{{ $errors->first('temp_limit') }}</strong></span>
    @endif
</div>

<!-- hr_limit Field -->
<div class="form-group col-sm-6 {{ $errors->has('hr_limit') ? ' has-error' : '' }}">
    {!! Form::label('hr_limit', 'Hashrate warning level (in Ghs):') !!}
    {!! Form::text('hr_limit', null, ['class' => 'form-control','placeholder' => '11500']) !!}
    @if ($errors->has('hr_limit'))
        <span class="help-block"><strong>{{ $errors->first('hr_limit') }}</strong></span>
    @endif
</div>

<div class="clearfix"></div>

<!-- Url Field -->
<div class="form-group col-sm-12  {{ $errors->has('url') ? ' has-error' : '' }}">
    {!! Form::label('url', 'Management Url (just in case you need fast access to bitmain web interface):') !!}
    {!! Form::text('url', null, ['class' => 'form-control','placeholder' => 'http://100.84.213.43:2101/cgi-bin/minerConfiguration.cgi']) !!}
    @if ($errors->has('url'))
        <span class="help-block"><strong>{{ $errors->first('url') }}</strong></span>
    @endif
</div>



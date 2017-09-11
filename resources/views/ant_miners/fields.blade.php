<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::select('type',['bmminer' => 'AntMiner T9/S9','cgminer' => 'AntMiner S7'], null, ['class' => 'form-control']) !!}
</div>
<!-- Host Field -->
<div class="form-group col-sm-6">
    {!! Form::label('host', 'Host:') !!}
    {!! Form::text('host', null, ['class' => 'form-control']) !!}
</div>

<!-- Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('port', 'Port:') !!}
    {!! Form::text('port', null, ['class' => 'form-control']) !!}
</div>

<!-- temp_limit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('temp_limit', 'Temperature Warning level:') !!}
    {!! Form::text('temp_limit', null, ['class' => 'form-control']) !!}
</div>

<!-- hr_limit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hr_limit', 'HashRate Warning level:') !!}
    {!! Form::text('hr_limit', null, ['class' => 'form-control']) !!}
</div>


<!-- Url Field -->
<div class="form-group col-sm-12">
    {!! Form::label('url', 'Management Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

@if(isset($keys))
    <!-- Options Field -->
    <div class="form-group col-sm-4">
        <h4>Detected Fans:</h4>
        @foreach($keys as $key => $value)
            @if(substr( $key, 0, 3 ) === "fan" && substr( $key, 0, 4 ) !== "fan_" && $value != 0)
                <div class="checkbox">
                    <label>
                        {{Form::checkbox('options['.$key.']', $key, 1,['onclick='=>'return false;'])}}
                        {{$key}}: {{$value}}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Options Field -->
    <div class="form-group col-sm-4">
        <h4>Detected  Temperatures:</h4>
        @foreach($keys as $key => $value)
            @if(substr( $key, 0, 4 ) === "temp" && substr( $key, 0, 5 ) !== "temp_" && $value != 0)
                <div class="checkbox">
                    <label>
                        {{Form::checkbox('options['.$key.']', $key, 1,['onClick'=>'return false;'])}}
                        {{$key}}: {{$value}}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Options Field -->
    <div class="form-group col-sm-4">
        <h4>Detected Hash boards:</h4>
        @foreach($keys as $key => $value)
            @if(substr( $key, 0, 9 ) === "chain_acn" && $value != 0)
                <div class="checkbox">
                    <label>
                        {{Form::checkbox('options['.$key.']', $key, 1,['onclick='=>'return false;'])}}
                        {{$key}}: {{$value}}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
@endif

@if(isset($keys))
<!-- Options Field
<div class="form-group col-sm-3">
    @foreach($keys as $key => $value)
    <div class="checkbox">
        <label>
            <input type="checkbox">
            {{Form::checkbox('options['.$key.']', $key)}}
            {{$key}}: {{$value}}
        </label>
    </div>
    @endforeach
</div>
-->
@endif


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('antMiners.index') !!}" class="btn btn-default">Cancel</a>
</div>

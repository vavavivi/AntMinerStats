<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $alert->id !!}</p>
</div>

<!-- Miner Id Field -->
<div class="form-group">
    {!! Form::label('miner_id', 'Miner Id:') !!}
    <p>{!! $alert->miner_id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $alert->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $alert->updated_at !!}</p>
</div>


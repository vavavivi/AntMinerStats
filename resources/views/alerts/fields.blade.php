<!-- Miner Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('miner_id', 'Miner Id:') !!}
    {!! Form::text('miner_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('alerts.index') !!}" class="btn btn-default">Cancel</a>
</div>

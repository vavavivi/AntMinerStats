@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Add new AntMiner
        </h1>
    </section>
    <div class="content">
        {{-- @include('adminlte-templates::common.errors') --}}
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'antMiners.store']) !!}
                        @include('ant_miners.fields')

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('antMiners.index') !!}" class="btn btn-default">Cancel</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <section class="content-header">

    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('ant_miners.show_fields')
                    <a href="{!! route('antMiners.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

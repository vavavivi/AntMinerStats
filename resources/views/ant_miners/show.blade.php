@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>View: {!! $antMiner->title !!} <small>({{$stats['stats']['Type']}})</small></h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="table-responsive" style="padding-left: 0px">
                    @include('ant_miners.show_fields')
                    <a href="{!! route('antMiners.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

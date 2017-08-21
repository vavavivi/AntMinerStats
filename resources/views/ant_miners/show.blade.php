@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>View: {!! $antMiner->title !!} <small>({{$stats['stats']['Type']}})</small></h1>
    </section>
    <div class="content">
        @include('ant_miners.show_fields')

        <a href="{!! route('antMiners.index') !!}" class="btn btn-info">&larr; Back to list</a>
        @if($antMiner->url)
            <a href="{{$antMiner->url}}" class='btn btn-success' target="_blank"><i class="glyphicon glyphicon-share"></i> Manage</a>
        @else
            <a href="#" class='btn btn-success disabled' target="_blank"><i class="glyphicon glyphicon-share"></i> Manage</a>
        @endif
        <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class="btn btn-warning"><i class="fa fa-cog"></i> Edit configuration</a>

    </div>
@endsection

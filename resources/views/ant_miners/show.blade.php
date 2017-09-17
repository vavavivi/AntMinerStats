@extends('layouts.app')

@section('title',"View: \"$antMiner->title\" -")

@section('content')
    <section class="content-header">
        <h1 class="pull-left">View: {!! $antMiner->title !!} <small>{{$antMiner->type == 'bmminer' ? 'Antminer S9/T9' : 'Antminer S7'}}</small></h1>
        <h1 class="pull-right hidden-xs">
            <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class="btn btn-sm  btn-warning pull-right"><i class="fa fa-cog"></i> Configuration</a>
            @if($antMiner->url)
                <a href="{{$antMiner->url}}" class="btn btn-sm btn-success pull-right" target="_blank"><i class="glyphicon glyphicon-share"></i> Manage</a>
            @else
                <a href="#" class="btn btn-sm btn-success disabled pull-right" target="_blank"><i class="glyphicon glyphicon-share"></i> Manage</a>
            @endif
            <a href="{!! route('antMiners.index') !!}" class="btn btn-sm btn-info pull-right">&larr; Back</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('ant_miners.show_fields')

        <a href="{!! route('antMiners.index') !!}" class="btn btn-info">&larr; Back</a>
        @if($antMiner->url)
            <a href="{{$antMiner->url}}" class='btn btn-success' target="_blank"><i class="glyphicon glyphicon-share"></i> Manage</a>
        @else
            <a href="#" class='btn btn-success disabled' target="_blank"><i class="glyphicon glyphicon-share"></i> Manage</a>
        @endif
        <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class="btn btn-warning"><i class="fa fa-cog"></i> Configuration</a>
    </div>
@endsection

@extends('layouts.app')

@section('title',"View: \"$antMiner->title\" -")

@section('content')
    <div class="content">
        <div class="clearfix"></div>
        @include('ant_miners.show_fields')
        <a href="{!! route('antMiners.index') !!}" class="btn btn-primary">&larr; Back</a>
        @if($antMiner->url)
            <a href="{{$antMiner->url}}" class='btn btn-success' target="_blank"><i class="glyphicon glyphicon-share"></i> Manage</a>
        @endif
        <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class="btn btn-warning"><i class="fa fa-cog"></i> Configuration</a>
    </div>
@endsection

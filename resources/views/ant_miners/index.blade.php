@extends('layouts.app')

@section('title',"Monitoring -")

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Miners</h1>
        <div class="btn-inline">
            <!-- BUTTON: ADD -->
            <a class="btn btn-sm btn-success" href="{!! route('antMiners.create') !!}"><span class="hidden-xs">Add miner </span> <i class="fa fa-plus"></i> </a>

            <!-- BUTTON: UPDATE -->
            <form method="POST" action="{{route('antMiners.force')}}" accept-charset="UTF-8">
                <button class="btn btn-sm btn-warning"><span class="hidden-xs">Update</span>  <i class="fa fa-refresh"></i></button>
            </form>
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        @include('ant_miners.table')
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection


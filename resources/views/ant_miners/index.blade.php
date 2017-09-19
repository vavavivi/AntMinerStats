@extends('layouts.app')

@section('title',"Monitoring -")

@section('content')
    <section class="content-header">
       <h1 class="pull-left">Miners</h1>
       <div class="btn-inline">
               <!-- BUTTON: ADD -->
               <a class="btn btn-sm btn-success" href="{!! route('antMiners.create') !!}"><span class="hidden-xs">Add miner </span> <i class="fa fa-plus"></i> </a>

               <!-- BUTTON: UPDATE -->
               {!! Form::open(['route' => ['antMiners.force'], 'method' => 'post']) !!}
               <button class="btn btn-sm btn-warning"><span class="hidden-xs">Update</span>  <i class="fa fa-refresh"></i></button>
               {!! Form::close() !!}
                {{--
                <!-- BUTTON: TABLE VIEW -->
                {!! Form::open(['route' => ['antMiners.view'], 'method' => 'post']) !!}
                <input type="hidden" name="view" value="table">
                <button class="btn btn-sm {{session()->get('miners_view','table') == 'table' ? 'btn-primary' : 'btn-white'}}">
                   <i class="fa fa-table"></i>
                </button>
                {!! Form::close() !!}

                <!-- BUTTON: WIDGET VIEW -->
                {!! Form::open(['route' => ['antMiners.view'], 'method' => 'post']) !!}
                <input type="hidden" name="view" value="widget">
                <button class="btn btn-sm {{session()->get('miners_view') == 'widget' ? 'btn-primary' : 'btn-white'}}">
                   <i class="fa fa-th-large"></i>
                </button>
                {!! Form::close() !!}
                --}}
            </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
            @if(session()->get('miners_view','table') == 'table')
                    @include('ant_miners.table')
            @else
                <div class="clearfix"></div>
                <br>
                @include('ant_miners.widget')
            @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>


    </script>
@endsection


@extends('layouts.app')

@section('title',"Monitoring -")

@section('content')
    <section class="content-header">
       {{-- --}} <h1 class="pull-left">AntMiners</h1>
        <h1 class="pull-right">

           <div class="btn-group">

               {!! Form::open(['route' => ['antMiners.force'], 'method' => 'post']) !!}

               <button class="btn btn-sm btn-primary">
                   <i class="fa fa-retweet"></i> Force reload
               </button>
               {!! Form::close() !!}

               <a class="btn btn-sm btn-success" href="{!! route('antMiners.create') !!}"><span class="hidden-xs">Add miner </span> <i class="fa fa-plus"></i> </a>

                {!! Form::open(['route' => ['antMiners.view'], 'method' => 'post']) !!}
                <input type="hidden" name="view" value="table">
                <button class="btn btn-sm {{session()->get('miners_view','table') == 'table' ? 'btn-primary' : 'btn-white'}}">
                    <i class="fa fa-table"></i>
                </button>
                {!! Form::close() !!}

                {!! Form::open(['route' => ['antMiners.view'], 'method' => 'post']) !!}
                <input type="hidden" name="view" value="widget">
                <button class="btn btn-sm {{session()->get('miners_view') == 'widget' ? 'btn-primary' : 'btn-white'}}">
                    <i class="fa fa-th-large"></i>
                </button>
                {!! Form::close() !!}
            </div>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body">
                @if(session()->get('miners_view','table') == 'table')
                    @include('ant_miners.table')
                @else
                    @include('ant_miners.widget')
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>


    </script>
@endsection


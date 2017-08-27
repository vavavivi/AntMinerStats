@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Available AntMiners</h1>
        <h1 class="pull-right">
           <a class="btn btn-sm btn-primary pull-right" href="{!! route('antMiners.create') !!}">Add miner <i class="fa fa-plus"></i> </a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="btn-group">
            {!! Form::open(['route' => ['antMiners.view'], 'method' => 'post']) !!}
            <input type="hidden" name="view" value="table">
            <button class="btn btn-md {{session()->get('miners_view','table') == 'table' ? 'btn-primary' : 'btn-white'}} m-r-5">
                <i class="fa fa-table"></i> Table mode
            </button>
            {!! Form::close() !!}

            {!! Form::open(['route' => ['antMiners.view'], 'method' => 'post']) !!}
            <input type="hidden" name="view" value="widget">
            <button class="btn btn-md {{session()->get('miners_view') == 'widget' ? 'btn-primary' : 'btn-white'}}">
                <i class="fa fa-th-large"></i> Widget mode
            </button>
            {!! Form::close() !!}
        </div>
        <div class="m-t-5">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        @if(session()->get('miners_view','table') == 'table')
                            @include('ant_miners.table')
                        @else
                            @include('ant_miners.widget')
                        @endif
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>


    </script>
@endsection


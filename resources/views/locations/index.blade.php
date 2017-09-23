@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Manage Locations</h1>
        <h1 class="pull-right">
           <a class="btn btn-sm btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('locations.create') !!}">Add new</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-body">
                        @include('locations.table')
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection


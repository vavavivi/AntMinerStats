@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Location
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($location, ['route' => ['locations.update', $location->id], 'method' => 'patch']) !!}
                        @include('locations.fields')
                        <div class="clearfix"></div>

                        <div class="form-group col-sm-4">
                           <h3>Available Miners:</h3>
                           @foreach(Auth::user()->miners as $miner)
                               @if(! $miner->location_id)
                                   <div class="checkbox form-group">
                                       <label>
                                           {!! Form::checkbox('miners[]',$miner->id,null) !!}
                                           {!! $miner->title !!}<br>
                                       </label>
                                   </div>
                               @endif
                           @endforeach
                        </div>
                        <div class="form-group col-sm-4">
                           <h3>Miners associated with {{$location->title}}</h3>
                           @foreach($location->miners as $miner)
                               <div class="checkbox">
                                   <label>
                                       {!! Form::checkbox('miners[]',$miner->id,null) !!}
                                       {!! $miner->title !!} <br>
                                   </label>
                               </div>
                           @endforeach
                        </div>
                        <div class="clearfix"></div>
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Apply', ['name'=>'apply','class' => 'btn btn-primary']) !!}
                            {!! Form::submit('Save & close', ['name'=>'save','class' => 'btn btn-success']) !!}
                           <a href="{!! route('locations.index') !!}" class="btn btn-default">Cancel</a>
                        </div>
                    {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
@extends('layouts.app')

@section('title',"Edit: \"$antMiner->title\" -")

@section('content')
   <div class="content">
       {{-- @include('adminlte-templates::common.errors') --}}
       <div class="box box-primary">
           <div class="box-header with-border">
               <i class="fa fa-cogs"></i>
               <h3 class="box-title">Edit <b>{!! $antMiner->title !!}</b></h3>
           </div>
           <div class="box-body">
               <div class="row">
                   {!! Form::model($antMiner, ['route' => ['antMiners.update', $antMiner->id], 'method' => 'patch']) !!}

                        @include('ant_miners.fields')
                       <div class="clearfix"></div>
                        @if($stats)
                           <!-- Options Field -->
                           <div class="form-group col-sm-2">
                               <h4>Fans:</h4>
                               <ul class="list-unstyled">
                                   @foreach($stats as $key => $value)
                                       @if(substr( $key, 0, 3 ) === "fan" && substr( $key, 0, 4 ) !== "fan_" && $value != 0)
                                           <li>Fan: <b>{{$key}}</b> ({{$value}} rpm) {{Form::hidden('options['.$key.']', $key)}}</li>
                                       @endif
                                   @endforeach
                               </ul>
                           </div>

                           <!-- Options Field -->
                           <div class="form-group col-sm-2">
                               <h4>Temperatures:</h4>
                               <ul class="list-unstyled">
                                   @foreach($stats as $key => $value)
                                       @if(substr( $key, 0, 4 ) === "temp" && substr( $key, 0, 5 ) !== "temp_" && $value != 0)
                                           <li>Temp: <b>{{$key}}</b>: {{$value}} °C {{Form::hidden('options['.$key.']', $key)}}</li>
                                       @endif
                                   @endforeach
                               </ul>
                           </div>

                           <!-- Options Field -->
                           <div class="form-group col-sm-3">
                               <h4>Detected Hash boards:</h4>
                               <ul class="list-unstyled">
                                   @foreach($stats as $key => $value)
                                       @if(substr( $key, 0, 9 ) === "chain_acn" && $value != 0)
                                           <li>Board <b>{{$key}}</b>: {{$value}} chips {{Form::hidden('options['.$key.']', $key)}}</li>
                                       @endif
                                   @endforeach
                               </ul>
                           </div>
                        @else
                           <div class="form-group col-md-12">
                               <div class="alert alert-warning">
                                   <h4><i class="icon fa fa-warning"></i> Warning!</h4>
                                   System cannot connect to your antminer and read hardware data. Please check your internet connections and settings.
                               </div>
                           </div>
                        @endif

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                           {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                           <a href="{!! route('antMiners.index') !!}" class="btn btn-default">Cancel</a>
                        </div>
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
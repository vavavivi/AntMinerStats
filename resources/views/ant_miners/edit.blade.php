@extends('layouts.app')

@section('title',"Edit: \"$antMiner->title\" -")

@section('content')
    <section class="content-header">
        <h1>
            Edit miner: {!! $antMiner->title !!}
        </h1>
   </section>
   <div class="content">
       {{-- @include('adminlte-templates::common.errors') --}}
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($antMiner, ['route' => ['antMiners.update', $antMiner->id], 'method' => 'patch']) !!}

                        @include('ant_miners.fields')
                        @if(isset($keys))
                           <!-- Options Field -->
                               <div class="form-group col-sm-4">
                                   <h4>Detected Fans:</h4>
                                   @foreach($keys as $key => $value)
                                       @if(substr( $key, 0, 3 ) === "fan" && substr( $key, 0, 4 ) !== "fan_" && $value != 0)
                                           <div class="checkbox">
                                               <label>
                                                   {{Form::checkbox('options['.$key.']', $key, 1,['onclick='=>'return false;'])}}
                                                   {{$key}}: {{$value}}
                                               </label>
                                           </div>
                                       @endif
                                   @endforeach
                               </div>

                               <!-- Options Field -->
                               <div class="form-group col-sm-4">
                                   <h4>Detected  Temperatures:</h4>
                                   @foreach($keys as $key => $value)
                                       @if(substr( $key, 0, 4 ) === "temp" && substr( $key, 0, 5 ) !== "temp_" && $value != 0)
                                           <div class="checkbox">
                                               <label>
                                                   {{Form::checkbox('options['.$key.']', $key, 1,['onClick'=>'return false;'])}}
                                                   {{$key}}: {{$value}}
                                               </label>
                                           </div>
                                       @endif
                                   @endforeach
                               </div>

                               <!-- Options Field -->
                               <div class="form-group col-sm-4">
                                   <h4>Detected Hash boards:</h4>
                                   @foreach($keys as $key => $value)
                                       @if(substr( $key, 0, 9 ) === "chain_acn" && $value != 0)
                                           <div class="checkbox">
                                               <label>
                                                   {{Form::checkbox('options['.$key.']', $key, 1,['onclick='=>'return false;'])}}
                                                   {{$key}}: {{$value}}
                                               </label>
                                           </div>
                                       @endif
                                   @endforeach
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
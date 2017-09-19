@extends('layouts.app')


@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="content">
        {{-- @include('adminlte-templates::common.errors') --}}
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-plus"></i>
                <h3 class="box-title">Add new AntMiner</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'antMiners.store']) !!}
                        @include('ant_miners.fields')

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('antMiners.index') !!}" class="btn btn-default">Cancel</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-text-width"></i>
                <h3 class="box-title">Legend</h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Title</th>
                            <td>Title for your AntMiner that will be used in system</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>AntMiner Type. Currently supporting Antminers S9/T9 & S7</td>
                        </tr>
                        <tr>
                            <th>Host</th>
                            <td>
                                <p>Hostname or IP adress. Dont use <b>http(s)://</b> at the beginning.</p>
                                <p>Example: <b>example.com</b> or <b>100.84.213.43</b></p>
                                <p>Usually it is ip address ot hostname of your router</p>
                                <p>More information on router setup and port forwarding can be found <a>here</a></p>
                            </td>
                        </tr>
                        <tr>
                            <th>Port</th>
                            <td>
                                <p>Antminer API port. Usually its 4028. But first of all you need to</p>
                                <p>forward traffic from your external to local IP of your antminer</p>
                                <p>More information on router setup and port forwarding can be found <a>here</a></p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Temperature warning level</th>
                            <td>Highest temperature on hashboard. On reaching this limit alert will be generated</td>
                        </tr>
                        <tr>
                            <th>Hashrate warning level</th>
                            <td>On reaching this limit alert will be generated</td>
                        </tr>
                        <tr>
                            <th>Management Url</th>
                            <td>
                                <p>Quick ability to enter your Antminer management web interface.</p>
                                <p>Note that we dont need neither access to this page nor login/pass.</p>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

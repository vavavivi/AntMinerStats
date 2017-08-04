@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel">
                    <div class="panel-body">
                        <h1>Welcome to AntSTATS</h1>
                        <p>
                            Fast monitoring system of <b>BITMAIN ANTMINER</b> information received by API
                        </p>
                        <h3>Syestem features:</h3>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-check"></i> Add/Remove miners to list</li>
                            <li><i class="fa fa-check"></i> Adaptive design</li>
                            <li><i class="fa fa-check"></i> Color indications of stats</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-cubes"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Number of Miners</span>
                        <span class="info-box-number">xx</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Number of Users</span>
                        <span class="info-box-number">1</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

        </div>
    </section>
@endsection

@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-sm-4 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-cog fa-spin"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Active / Total Miners</span>
                        <span class="info-box-number">{{Auth::user()->miners->count()}} / {{Auth::user()->miners->count()}}</span>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-rocket animated infinite pulse"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total productivity</span>
                        <span class="info-box-number">xxxx TH/s</span>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-warning"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Alerts</span>
                        <span class="info-box-number">0</span>
                    </div>
                </div>
            </div>



            <div class="col-sm-8 col-xs-12">
                <div class="box box-default">
                    <div class="box-header">
                        <h2>Welcome to AntSTATS <sup>v.1.0</sup></h2>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
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
                    <div class="box-footer">
                        <button type="button" class="btn btn-sm btn-primary" data-widget="remove">Hide this message</button>
                        <input type="checkbox"> <span>Don't show again</span>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Miners</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="chart-container">
                            {!! $chartjs_miners->render() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
@endsection

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
                    <div class="box-header with-border">
                        <h3 class="box-title">Overall miners hashrate</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="m-t-5">
                            <button type="button" class="btn btn-xs btn-info" data-widget="collapse">1D</button>
                            <button type="button" class="btn btn-xs btn-default" data-widget="collapse">1H</button>
                        </div>
                        <div class="chart-container">
                            <canvas id="ths-graph" height="95vw"></canvas>
                        </div>
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
                            <canvas id="miners-graph" height="227vw"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
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


        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
    <script>
        window.chartColors = {
            red:    'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green:  'rgb(75, 192, 192)',
            blue:   'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey:   'rgb(201, 203, 207)'
        };

        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
        };

        var config1 = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                    backgroundColor: [
                        window.chartColors.red,
                        window.chartColors.yellow,
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    "AntMiner S7",
                    "AntMiner S9/T9",
                ]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        var config2 = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August",],
                datasets: [{
                    label: "Hashrate, TH/s ",
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [18, 33, 35, 15, 39, 40, 46, 49],
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                            suggestedMin: 0
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("miners-graph").getContext("2d");
            window.myDoughnut = new Chart(ctx, config1);

            var ctx = document.getElementById("ths-graph").getContext("2d");
            window.myLine = new Chart(ctx, config2);
        };
</script>
@endsection

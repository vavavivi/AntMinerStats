@extends('layouts.app')

@section('content')
    <div class="content">
        {{-- @include('adminlte-templates::common.errors') --}}
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-info-circle"></i>
                <h2 class="box-title"><b>F</b>requency <b>A</b>sk <b>Q</b>uestion:</h2>
            </div>
            <div class="box-body">
                    <a data-toggle="collapse" href="#q1">
                        <h4>1. Is it safe to grant access to API of your antminer to our monitoring service?</h4>
                    </a>
                    <div class="well collapse" id="q1">
                        All latest  <a href="https://shop.bitmain.com/support.htm" target="_blank">AntMiner firmware</a> provides <strong>read-only</strong> access by default.
                        And we cannot access any privileged command that affects the miner.
                        That means, that we can read all data from your hardware, but we cannot write or change any of your settings.
                    </div>

                    <a data-toggle="collapse" href="#q2">
                        <h4>2. Is there an integration guide for PHP frameworks such as Yii or Symfony?</h4>
                    </a>
                    <div class="well collapse" id="q2">
                        Short answer, no. However, there are forks and tutorials around the web that provide info on how to integrate with many different frameworks. There are even versions of AdminLTE that are integrated with jQuery ajax, AngularJS and/or MVC5 ASP .NET.
                    </div>

                    <a data-toggle="collapse" href="#q3">
                        <h4>3. How do I get notified of new AdminLTE versions?</h4>
                    </a>
                    <div class="well collapse" id="q3">
                        The best option is to subscribe to our mailing list using the <a href="https://adminlte.io/#subscribe">subscription form on Almsaeed Studio</a>.
                        If that's not appealing to you, you may watch the <a href="https://github.com/almasaeed2010/AdminLTE">repository on Github</a> or visit <a href="https://adminlte.io">Almsaeed Studio</a> every now and then for updates and announcements.
                    </div>
            </div>
        </div>
    </div>
@endsection



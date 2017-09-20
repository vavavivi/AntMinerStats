@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-cogs"></i>
                <h3 class="box-title">Faq</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Is it safe to grant access to API of your antminer to our monitoring service?
                                </h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body" style="">
                                All latest firmware provides read-only access by default.
                                That means, that we can read all data from your hardware, but we cannot write or change any of your settings.
                                However, we have optional functionality of remote restart miners via API.
                                And to enable this functionality you have to make some changes to cgminer.conf via SSH.
                                To make it safer, you can setup your antminer to allow write acceess ONLY from IP address of our service.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Is it safe to grant access to API of your antminer to our monitoring service?
                                </h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body" style="">
                                All latest firmware provides read-only access by default.
                                That means, that we can read all data from your hardware, but we cannot write or change any of your settings.
                                However, we have optional functionality of remote restart miners via API.
                                And to enable this functionality you have to make some changes to cgminer.conf via SSH.
                                To make it safer, you can setup your antminer to allow write acceess ONLY from IP address of our service.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Is it safe to grant access to API of your antminer to our monitoring service?
                                </h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body" style="">
                                All latest firmware provides read-only access by default.
                                That means, that we can read all data from your hardware, but we cannot write or change any of your settings.
                                However, we have optional functionality of remote restart miners via API.
                                And to enable this functionality you have to make some changes to cgminer.conf via SSH.
                                To make it safer, you can setup your antminer to allow write acceess ONLY from IP address of our service.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


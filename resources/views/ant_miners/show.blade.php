@extends('layouts.app')

@section('content')
    <section class="content-header">
        {{$antMiner->title}} info
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-5">
                        <div id="temps_div"></div>
                        <div id="freqs_div"></div>
                        <div id="hr_div"></div>
	                    <?= Lava::render('LineChart', 'Temps', 'temps_div') ?>
	                    <?= Lava::render('LineChart', 'Freqs', 'freqs_div') ?>
	                    <?= Lava::render('LineChart', 'HashRate', 'hr_div') ?>
                    </div>
                    <div class="col-sm-7">
                        <div class="table-responsive" style="padding-left: 0px">
                            @include('ant_miners.show_fields')
                            <a href="{!! route('antMiners.index') !!}" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

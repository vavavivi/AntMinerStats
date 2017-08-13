@extends('layouts.app')

@section('css')
    <style>
        canvas{
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">

    </section>

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">

                <div id="temps_div"></div>
                <div id="freqs_div"></div>
                <div id="hr_div"></div>
	            <?= Lava::render('LineChart', 'Temps', 'temps_div') ?>
	            <?= Lava::render('LineChart', 'Freqs', 'freqs_div') ?>
	            <?= Lava::render('LineChart', 'HashRate', 'hr_div') ?>


                <div class="table-responsive" style="padding-left: 0px">
                    <a href="{!! route('antMiners.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')

@endsection
<?php

namespace App\Http\Controllers;

use App\Models\AntMiner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lava;

class LogController extends Controller
{
    public function show_old($id)
    {
	    $antMiner = AntMiner::find($id);

	    if(!$antMiner)
	    {
		    return redirect()->back();
	    }

	    $logs = $antMiner->antlogs;

	    $temperatures = Lava::DataTable();
	    $freqs = Lava::DataTable();
	    $hr = Lava::DataTable();

	    $temperatures->addDateColumn('Date')
		    ->addNumberColumn('HB#1')
		    ->addNumberColumn('HB#2')
		    ->addNumberColumn('HB#3');
	    ;

	    $freqs->addDateColumn('Date')
		    ->addNumberColumn('HB#1')
		    ->addNumberColumn('HB#2')
		    ->addNumberColumn('HB#3');
	    ;

	    $hr->addDateColumn('Date')
		    ->addNumberColumn($antMiner->title);
	    ;

		    foreach($logs as $log)
		    {
		    	$date = $log->created_at->format('d.m.Y H:i');

			    $data_temp  = [$date, $log->temp1, $log->temp2, $log->temp3];
			    $data_freq  = [$date, $log->freq1, $log->freq2, $log->freq3];
			    $data_hr    = [$date, $log->hr];


			    $temperatures->addRow($data_temp);
			    $freqs->addRow($data_freq);
			    $hr->addRow($data_hr);

			    $data_temp = null;
			    $data_freq = null;
			    $data_hr = null;
		    }

	    Lava::LineChart('Temps', $temperatures, [
		    'title' => 'Hash Board Temps',
	    ]);

	    Lava::LineChart('Freqs', $freqs, [
		    'title' => 'Hash Board Freqs',
	    ]);

	    Lava::LineChart('HashRate', $hr, [
		    'title' => 'Hash Rate',
	    ]);


	    return view('ant_miners.show_log');

    }

    public function show($id)
    {

	    $antMiner = AntMiner::find($id);

	    if(!$antMiner)
	    {
		    return redirect()->back();
	    }

	    $logs = $antMiner->antlogs;

	    $hourly = $logs->groupBy(function($log) {
		    return $log->created_at->format('Y-m-d H');
	    });

	    $temperatures = Lava::DataTable();
	    $freqs = Lava::DataTable();
	    $hr = Lava::DataTable();

	    $temperatures->addDateColumn('Date')
		    ->addNumberColumn('HB#1')
		    ->addNumberColumn('HB#2')
		    ->addNumberColumn('HB#3');
	    ;

	    $freqs->addDateColumn('Date')
		    ->addNumberColumn('HB#1')
		    ->addNumberColumn('HB#2')
		    ->addNumberColumn('HB#3');
	    ;

	    $hr->addDateColumn('Date')
		    ->addNumberColumn($antMiner->title);
	    ;

	    foreach($hourly as $hour => $data)
	    {
		    $temp1 = null;
		    $temp2 = null;
		    $temp3 = null;

		    $freq1 = null;
		    $freq2 = null;
		    $freq3 = null;

		    $hr1 = null;

	    	foreach($data as $sdata)
		    {
			    $temp1 = $temp1 + $sdata->temp1;
				$temp2 = $temp2 + $sdata->temp2;
				$temp3 = $temp3 + $sdata->temp3;

			    $freq1 = $freq1 + $sdata->freq1;
			    $freq2 = $freq2 + $sdata->freq2;
			    $freq3 = $freq3 + $sdata->freq3;

			    $hr1 = $hr1 + $sdata->hr;
		    }

		    $a = $data->count();
	    	$date = $data->first()->created_at;

		    $data_temp  = [$date, round($temp1/$a, 0), round($temp2/$a, 0), round($temp3/$a, 0)];
		    $data_freq  = [$date, round($freq1/$a, 0), round($freq2/$a, 0), round($freq3/$a, 0)];
		    $data_hr    = [$date, round($hr1/$a, 0)];


		    $temperatures->addRow($data_temp);
		    $freqs->addRow($data_freq);
		    $hr->addRow($data_hr);

	    }

	    Lava::LineChart('Temps', $temperatures, [
		    'title' => 'Hash Board Temps',
	    ]);

	    Lava::LineChart('Freqs', $freqs, [
		    'title' => 'Hash Board Freqs',
	    ]);

	    Lava::LineChart('HashRate', $hr, [
		    'title' => 'Hash Rate',
	    ]);


	    return view('ant_miners.show_log');

    }

}

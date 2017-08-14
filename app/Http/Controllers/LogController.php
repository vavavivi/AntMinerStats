<?php

namespace App\Http\Controllers;

use App\Models\AntMiner;
use Illuminate\Http\Request;
use Lava;

class LogController extends Controller
{
    public function show($id)
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

}

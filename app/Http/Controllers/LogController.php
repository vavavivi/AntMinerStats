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

	    $logs = $antMiner->antMinerlogs;

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

	    if($antMiner->type == 'bmminer')
	    {
		    foreach($logs as $log)
		    {
			    $data_temp  = [$log->created_at->format('d.m.Y H:i')];
			    $data_freq  = [$log->created_at->format('d.m.Y H:i')];
			    $data_hr    = [$log->created_at->format('d.m.Y H:i'), intval (round($log->data['hash_rate'],0))];
			    foreach($log->data['chains'] as $chain_id => $chain)
			    {
				    array_push($data_temp, intval ($chain['brd_temp1']));
				    array_push($data_freq, intval ($chain['brd_freq']));
			    }

			    $temperatures->addRow($data_temp);
			    $freqs->addRow($data_freq);
			    $hr->addRow($data_hr);

			    $data_temp = null;
			    $data_freq = null;
			    $data_hr = null;
		    }
	    }
	    else
	    {
		    foreach($logs as $log)
		    {
			    $data_temp  = [$log->created_at->format('d.m.Y H:i')];
			    $data_freq  = [$log->created_at->format('d.m.Y H:i')];
			    $data_hr    = [$log->created_at->format('d.m.Y H:i'), intval (round($log->data['hash_rate'],0))];
			    foreach($log->data['chains'] as $chain_id => $chain)
			    {
				    array_push($data_temp, intval ($chain['brd_temp']));
				    array_push($data_freq, intval ($chain['brd_freq']));
			    }

			    $temperatures->addRow($data_temp);
			    $freqs->addRow($data_freq);
			    $hr->addRow($data_hr);

			    $data_temp = null;
			    $data_freq = null;
			    $data_hr = null;
		    }
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

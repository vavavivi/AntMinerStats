<?php

namespace App\Http\Controllers;

use App\AntMinerLog;
use App\Models\AntMiner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    	$miners = AntMiner::all();

    	$st9 = $miners->where('type','bmminer');
    	$s7 = $miners->where('type','cgminer');

	    $avg = [];
	    $temp = [];
	    $date_array = [];
	    $hashrate_array = [];

    	foreach($miners as $miner)
	    {
			$daily = $miner->antlogs->groupBy(function($log) {
			    return $log->created_at->format('d M');
		    });

		    foreach($daily as $day => $logs)
		    {
		    	$avg[$miner->id][$day] = round($logs->avg('hr')/1024, 2);
		    }
	    }



	    foreach($avg as $miner_id => $data)
	    {
	    	foreach($data as $date => $avg_hashrate)
		    {
		    	if(key_exists($date, $temp))
			    {
			    	$temp[$date] = ($temp[$date] + $avg_hashrate);
			    }
			    else
			    {
				    $temp[$date] = $avg_hashrate;
				    $date_array[] = $date;
			    }
		    }
	    }




	    foreach($temp as $date_index => $hasrate)
	    {
	    	$hashrate_array[] = $hasrate;
	    }




        $chartjs_th = app()->chartjs
            ->name('OverallHashrate')
            ->type('line')
            ->size(['width' => 400, 'height' => 150])
            ->labels($date_array)
            ->datasets([
                [
                    "label" => "Hashrate",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $hashrate_array,
                ]
            ]);

        $chartjs_miners = app()->chartjs
            ->name('MinersType')
            ->type('doughnut')
            ->size(['width' => 400, 'height' => 350])
            ->labels(['AntMiner S7', 'AntMiner S9/T9'])
            ->datasets([
                [
                    "label" => "Miners Types",
                    "backgroundColor" => ['rgb(255, 99, 132)', 'rgb(255, 205, 86)'],

                    'data' => [$s7->count(), $st9->count()],
                ]
            ]);

        return view('home', compact('chartjs_th','chartjs_miners'));
    }
}

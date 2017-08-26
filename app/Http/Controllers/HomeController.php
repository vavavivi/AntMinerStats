<?php

namespace App\Http\Controllers;

use App\Models\AntMiner;
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

    	$st9 = AntMiner::where('type','bmminer')->count();
    	$s7 = AntMiner::where('type','cgminer')->count();

        $chartjs_th = app()->chartjs
            ->name('OverallHashrate')
            ->type('line')
            ->size(['width' => 400, 'height' => 150])
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August'])
            ->datasets([
                [
                    "label" => "Hashrate",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [12, 20, 25, 28, 24, 38, 39,43],
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

                    'data' => [$s7, $st9],
                ]
            ]);

        return view('home', compact('chartjs_th','chartjs_miners'));
    }
}

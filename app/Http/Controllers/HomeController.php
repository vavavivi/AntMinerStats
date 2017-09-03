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

    	$miners = \Auth::user()->miners;

    	$st9 = $miners->where('type','bmminer');
    	$s7 = $miners->where('type','cgminer');

        $chartjs_miners = app()->chartjs
            ->name('MinersType')
            ->type('doughnut')
            ->size(['width' => 400, 'height' => 265])
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

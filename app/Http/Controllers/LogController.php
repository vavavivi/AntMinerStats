<?php

namespace App\Http\Controllers;

use App\Models\AntMiner;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function show($id)
    {
        $antMiner = AntMiner::find($id);

        if(!$antMiner)
        {
            return redirect()->back();
        }

        $log = $antMiner->antMinerlogs;

        return view('ant_miners.show_log')
            ->with('log', $log)
            ->with('antMiner',$antMiner);

    }
}

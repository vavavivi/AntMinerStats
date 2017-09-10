<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAntMinerRequest;
use App\Http\Requests\UpdateAntMinerRequest;
use App\Models\AntMiner;
use App\Repositories\AntMinerRepository;
use App\Http\Controllers\AppBaseController;
use App\Traits\MinerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Lava;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Telegram\Bot\Api;

class AntMinerController extends AppBaseController
{
    use MinerTrait;

    private $antMinerRepository;

    public function __construct(AntMinerRepository $antMinerRepo)
    {
        $this->antMinerRepository = $antMinerRepo;
    }

    public function index(Request $request)
    {
	    $antMiners = AntMiner::all()->where('user_id',\Auth::id());
        $data = [];

		foreach($antMiners as $antMiner)
		{
			if($antMiner->active)
			{
				$miner_data = $this->formatMinerData($antMiner);
				$data[$antMiner->id] = $miner_data;
			}
			else
			{
				$data[$antMiner->id] = null;
			}

		}

        return view('ant_miners.index')
            ->with('antMiners', $antMiners)
            ->with('data', $data);
    }

    public function create()
    {
        return view('ant_miners.create');
    }

    public function store(CreateAntMinerRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::id();

        //order routine
	    $last_antMiner = \Auth::user()->miners->sortBy('order')->last();

	    if($last_antMiner)
	    {
	    	$input['order'] = $last_antMiner->order + 1;
	    }
	    else
	    {
		    $input['order'] = 10;
	    }

	    $antMiner = $this->antMinerRepository->create($input);

        Flash::success('Ant Miner saved successfully.');

        return redirect(route('antMiners.edit',$antMiner->id));
    }

    public function show($id)
    {
        $antMiner = $this->antMinerRepository->findWithoutFail($id);

        if (empty($antMiner)) {
            Flash::error('Ant Miner not found');

            return redirect(route('antMiners.index'));
        }

	    if ($antMiner->user_id != \Auth::id() && \Auth::id() != 1) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }


        $stats_all = $this->get_api_data($antMiner);

        $stats['summary'] = $this->parseStats($stats_all['summary']);
	    $stats['pools'] = $this->parsePools($stats_all['pools']);
	    $stats['stats'] = $this->parseStats($stats_all['stats']);

	    foreach($antMiner->options as $option_key => $option_value)
	    {
	    	if(substr( $option_key, 0, 3 ) === "fan")
		    {
		    	$stats['selected']['fans'][$option_key] = $stats['stats'][$option_key];
		    }

		    if(substr( $option_key, 0, 9 ) === "chain_acn")
		    {
		    	$chain_index = substr( $option_key, -1, 1 );

		    	$brd_chips_var = 'chain_acn'.$chain_index;
		    	$brd_chips_stat_var = 'chain_acs'.$chain_index;


			    $stats['selected']['chains'][$chain_index]['chips'] = $stats['stats'][$brd_chips_var];
			    $stats['selected']['chains'][$chain_index]['chips_stat'] = str_split(str_replace(' ', '', $stats['stats'][$brd_chips_stat_var]));


			    if($antMiner->type == 'bmminer')
			    {
				    $brd1_temp_var = 'temp2_'.$chain_index;
				    $brd2_temp_var = 'temp3_'.$chain_index;

				    $brd_freq_var = 'freq_avg'.$chain_index;

				    $stats['selected']['chains'][$chain_index]['brd_temp1'] = $stats['stats'][$brd1_temp_var];
				    $stats['selected']['chains'][$chain_index]['brd_temp2'] = $stats['stats'][$brd2_temp_var];
				    $stats['selected']['chains'][$chain_index]['brd_freq'] = $stats['stats'][$brd_freq_var];
			    }
			    else
			    {
				    $brd_temp_var = 'temp'.$chain_index;
				    $stats['selected']['chains'][$chain_index]['brd_temp'] = $stats['stats'][$brd_temp_var];
			    }


		    }
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

        return view('ant_miners.show')->with('antMiner', $antMiner)->with('stats', $stats);
    }

    public function edit($id)
    {
        $antMiner = $this->antMinerRepository->findWithoutFail($id);

        if (empty($antMiner)) {
            Flash::error('Ant Miner not found');

            return redirect(route('antMiners.index'));
        }

	    if ($antMiner->user_id != \Auth::id() && \Auth::id() != 1) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

	    $keys = [];

	    $stats_all = $this->get_api_data($antMiner);
        $result = $this->parseStats($stats_all['stats']);

	    foreach($result as $key => $value)
	    {
		    $keys[$key] = $value;
	    }

        return view('ant_miners.edit')->with('antMiner', $antMiner)->with('keys', $keys);
    }

    public function update($id, UpdateAntMinerRequest $request)
    {
        $antMiner = $this->antMinerRepository->findWithoutFail($id);

        $input = $request->all();

        if(! $request->has('log'))
        {
            $input['log'] = false;
        }
        else
        {
            $input['log'] = true;
        }

        if (empty($antMiner)) {
            Flash::error('Ant Miner not found');

            return redirect(route('antMiners.index'));
        }

	    if ($antMiner->user_id != \Auth::id() && \Auth::id() != 1) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

        $antMiner = $this->antMinerRepository->update($input, $id);

        Flash::success('Ant Miner updated successfully.');

        return redirect(route('antMiners.index'));
    }

    public function destroy($id)
    {
        $antMiner = $this->antMinerRepository->findWithoutFail($id);

        if (empty($antMiner)) {
            Flash::error('Ant Miner not found');

            return redirect(route('antMiners.index'));
        }

	    if ($antMiner->user_id != \Auth::id()) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

        $this->antMinerRepository->delete($id);

        Flash::success('Ant Miner deleted successfully.');

        return redirect(route('antMiners.index'));
    }

    public function view(Request $request)
    {
	    session(['miners_view' => $request->view]);

		return redirect()->back();
    }

    public function set_desc($id)
    {
	    $antMiner = $this->antMinerRepository->findWithoutFail($id);

	    if (empty($antMiner)) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

	    if ($antMiner->user_id != \Auth::id()) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

	    $cur_order = $antMiner->order;

	    $antMiners = \Auth::user()->miners->sortBy('order');

	    $next_antMiner = $antMiners->where('order', '>', $cur_order)->first();

	    if($next_antMiner)
	    {
		    $des_order = $next_antMiner->order;
		    $next_antMiner->update(['order' => $cur_order]);
		    $antMiner->update(['order' => $des_order]);
	    }
	    else
	    {
		    $antMiner->update(['order' => $cur_order + 1]);
	    }

	    return redirect()->back();

    }

    public function set_asc($id)
    {
	    $antMiner = $this->antMinerRepository->findWithoutFail($id);

	    if (empty($antMiner)) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

	    if ($antMiner->user_id != \Auth::id()) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

	    $cur_order = $antMiner->order;

	    $antMiners = \Auth::user()->miners->sortByDesc('order');
	    $next_antMiner = $antMiners->where('order', '<', $cur_order)->first();

	    if($next_antMiner)
	    {
		    $des_order = $next_antMiner->order;
		    $next_antMiner->update(['order' => $cur_order]);
		    $antMiner->update(['order' => $des_order]);
	    }
	    else
	    {
		    $antMiner->update(['order' => $cur_order - 1]);
	    }

	    return redirect()->back();
    }

    public function state($id)
    {
	    $antMiner = $this->antMinerRepository->findWithoutFail($id);

	    if (empty($antMiner)) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

	    if ($antMiner->user_id != \Auth::id()) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

	    $new_state = $antMiner->active ? false : true;

	    if(!$new_state)
	    {
	    	$reason = 'Disabled manualy on: '. Carbon::now()->format('d.m.Y H:i:s').' from IP: ' .request()->ip();
	    }
	    else
	    {
	    	$reason = null;
	    }

	    $antMiner->update(['active' => $new_state, 'd_reason' => $reason]);

	    return redirect(route('antMiners.index'));
    }

}

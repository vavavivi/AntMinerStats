<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAntMinerRequest;
use App\Http\Requests\UpdateAntMinerRequest;
use App\Jobs\PollMinerQ;
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
	    $antMiners = AntMiner::all()->where('user_id',\Auth::id())->groupBy('location_id')->sortBy('order');

	    //return $antMiners;
        $data = [];

		foreach($antMiners as $location_id => $location_antMiners)
		{
			foreach($location_antMiners as $antMiner)
			{
				if($antMiner->active)
				{
					$data[$antMiner->id] = $antMiner->antlogs->sortByDesc('id')->first();
				}
				else
				{
					$data[$antMiner->id] = null;
				}
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

	    $miner_data = $this->formatMinerData($antMiner);
	    $antMinerLog = $this->storeLog($miner_data, $antMiner);



	    $pools = $this->get_api_pools($antMiner);
	    $summary = $this->get_api_summary($antMiner);

        if(! $antMinerLog || ! $pools || ! $summary)
        {
	        Flash::error('Ant Miner is offline');
	        $stats = null;
        }
        else
        {
	        $stats['stats'] = $miner_data;
	        $stats['summary'] = $this->parseStats($summary);
	        $stats['pools'] = $this->parsePools($pools);
        }


	    //return $stats['pools'];

	    $logs = $antMiner->antlogs->sortBy('id');


	    $hourly = $logs->groupBy(function($log) {
		    return $log->created_at->format('Y-m-d H');
	    });

	    $temperatures = Lava::DataTable();
	    $freqs = Lava::DataTable();
	    $hr = Lava::DataTable();
	    $cc = Lava::DataTable();
	    $hw = Lava::DataTable();

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

	    $hw->addDateColumn('Date')
		    ->addNumberColumn('hw %');
	    ;

	    $cc->addDateColumn('Date')
		    ->addNumberColumn('Chips OK')
		    ->addNumberColumn('Chips Error')
	    ;

	    foreach($hourly as $hour => $data)
	    {

		    $temperatures_data = [];
		    $freq_data = [];
		    $cc_data = [];
		    $hr_data = 0;
		    $hw_data = 0;

		    foreach($data as $sdata)
		    {
		    	//return $sdata;

		    	foreach($sdata['chains'] as $c_id => $chain)
			    {

			    	if(! array_key_exists($c_id, $temperatures_data))
				    {
					    $temperatures_data[$c_id] = 0;
				    }

				    if(! array_key_exists($c_id, $freq_data))
				    {
					    $freq_data[$c_id] = 0;
				    }

				    if(! array_key_exists('OK', $cc_data))
				    {
					    $cc_data['OK'] = 0;
				    }

				    if(! array_key_exists('ER', $cc_data))
				    {
					    $cc_data['ER'] = 0;
				    }

				    $temperatures_data[$c_id] = array_sum($chain['brd_temp']) / count($chain['brd_temp']) + $temperatures_data[$c_id];

				    $freq_data[$c_id] = $chain['brd_freq'] + $freq_data[$c_id];

				    $cc_data['OK'] = $chain['chips_condition']['ok'] + $cc_data['OK'];
				    $cc_data['ER'] = $chain['chips_condition']['er'] + $cc_data['ER'];
			    }

			    $hr_data = $sdata->hash_rate + $hr_data;
			    $hw_data = $sdata->hw + $hw_data;
		    }

		    $date = $data->first()->created_at;

		    $data_temp  = [$date];

		    foreach($temperatures_data as $c_id => $sum_temp)
		    {
			    array_push($data_temp, round($sum_temp/$data->count(), 0));
		    }

		    $data_freq  = [$date];

		    foreach($freq_data as $c_id => $sum_freq)
		    {
			    array_push($data_freq, round($sum_freq/$data->count(), 0));
		    }

		    $data_hr    = [$date, round($hr_data/$data->count(), 0)];
		    $data_hw    = [$date, $hw_data/$data->count()];
		    $data_cc    = [$date, round($cc_data['OK']/$data->count()), round($cc_data['ER']/$data->count(), 0)];

		    $temperatures->addRow($data_temp);
		    $freqs->addRow($data_freq);
		    $hr->addRow($data_hr);
		    $hw->addRow($data_hw);
		    $cc->addRow($data_cc);

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

	    Lava::LineChart('HWERR', $hw, [
		    'title' => 'HW Errors',
	    ]);

	    Lava::LineChart('Chips', $cc, [
		    'title' => 'Chips Count',
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

	    if ($antMiner->user_id != \Auth::id()) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

	    $stats_raw = $this->get_api_stats($antMiner);
	    $stats = $this->parseStats($stats_raw);


        return view('ant_miners.edit')->with('antMiner', $antMiner)->with('stats', $stats);
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

    public function force()
    {
	    $antMiners = AntMiner::all()->where('user_id',\Auth::id());

	    foreach($antMiners as $antMiner)
	    {
		    if($antMiner->active)
		    {
			    PollMinerQ::dispatch($antMiner);
		    }
	    }

	    sleep(3);

	    return redirect()->back();
    }

}

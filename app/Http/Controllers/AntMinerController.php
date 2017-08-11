<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAntMinerRequest;
use App\Http\Requests\UpdateAntMinerRequest;
use App\Models\AntMiner;
use App\Repositories\AntMinerRepository;
use App\Http\Controllers\AppBaseController;
use App\Traits\MinerTrait;
use Illuminate\Http\Request;
use Flash;
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
	    $antMiners = \Auth::user()->miners->sortBy('type');
        $data = [];

		foreach($antMiners as $antMiner)
		{
			//return $this->formatMinerData($antMiner);
            $miner_data = $this->formatMinerData($antMiner);
			$data[$antMiner->id] = $miner_data;

			$antMiner->antMinerlogs()->create(['data'=>$miner_data]);

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

	    if ($antMiner->user_id != \Auth::id()) {
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

	    if ($antMiner->user_id != \Auth::id()) {
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
}

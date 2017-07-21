<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAntMinerRequest;
use App\Http\Requests\UpdateAntMinerRequest;
use App\Models\AntMiner;
use App\Repositories\AntMinerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Telegram\Bot\Api;

class AntMinerController extends AppBaseController
{
    private $antMinerRepository;

    public function __construct(AntMinerRepository $antMinerRepo)
    {
        $this->antMinerRepository = $antMinerRepo;
    }

    public function index(Request $request)
    {
	    $antMiners = \Auth::user()->miners;
        $data = [];

		foreach($antMiners as $antMiner)
		{
			//return $this->formatMinerData($antMiner);
			$data[$antMiner->id] = $this->formatMinerData($antMiner);
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

        if (empty($antMiner)) {
            Flash::error('Ant Miner not found');

            return redirect(route('antMiners.index'));
        }

	    if ($antMiner->user_id != \Auth::id()) {
		    Flash::error('Ant Miner not found');

		    return redirect(route('antMiners.index'));
	    }

        $antMiner = $this->antMinerRepository->update($request->all(), $id);

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

	private function read_from_socket(AntMiner $antMiner, $command)
	{
		$host = $antMiner->host;
		$port = $antMiner->port;

		$connection = null;

		try{
			ini_set("default_socket_timeout", 5);
			$connection = fsockopen($host, $port,$errstr);

		}
		catch(\Exception $e){

		}

		if (!$connection) {
			return false;
		}

		fwrite($connection, $command);
		$reply = stream_get_contents($connection);

		stream_socket_shutdown($connection, STREAM_SHUT_WR);
		fclose($connection);
		$connection = null;


		return $reply;
	}

    private function get_api_data(AntMiner $antMiner)
    {
	    $reply['stats'] = $this->get_api_stats($antMiner);
	    $reply['pools'] = $this->get_api_pools($antMiner);
	    $reply['summary'] = $this->get_api_summary($antMiner);

	    return $reply;
    }

	private function get_api_stats(AntMiner $antMiner)
	{
		return $this->read_from_socket($antMiner, 'stats');
	}

	private function get_api_pools(AntMiner $antMiner)
	{
		return $this->read_from_socket($antMiner, 'pools');
	}

    private function get_api_summary(AntMiner $antMiner)
    {
	    return $this->read_from_socket($antMiner, 'summary');
    }

    private function parseStats($array)
    {
	    $reply = explode('|',$array);
	    $result = [];

	    foreach($reply as $block=>$data_raw)
	    {
		    $data = explode(',',$data_raw);

		    foreach($data as $id=>$value)
		    {
			    if(substr( $value, 0, 11 ) === "chain_xtime" OR substr( $value, 0, 1 ) === "X")
			    {
			    }
			    else
			    {
				    $temp = explode('=',$value);
			    }

			    if(key_exists(0,$temp) && key_exists(1,$temp))
			    {
				    $result[$temp[0]] = $temp[1];
			    }
		    }
	    }

	    return $result;
    }

    private function parsePools($array)
    {
	    $reply = explode('|',$array);
	    $result = [];

	    foreach($reply as $block=>$data_raw)
	    {
	    	if(substr( $data_raw, 0, 6 ) === "STATUS")
		    {

		    }

		    else
		    {
			    $data = explode(',',$data_raw);
			    foreach($data as $id=>$value)
			    {
				    $temp = explode('=',$value);


				    if(key_exists(0,$temp) && key_exists(1,$temp))
				    {
					    $result[$block][$temp[0]] = $temp[1];
				    }
			    }
		    }
	    }

	    return $result;
    }

	private function formatMinerData(AntMiner $antMiner)
    {
	    $chip_ok_count = 0;
	    $chip_er_count = 0;

	    $miner_data = $this->get_api_stats($antMiner);

	    if(!$miner_data)
	    {
	    	return false;
	    }

	    $miner_stats = $this->parseStats($this->get_api_stats($antMiner));

	    $stats = null;

	    $stats['hash_rate'] = $miner_stats['GHS 5s'];

	    foreach($antMiner->options as $option_key => $option_value)
	    {
		    if(substr( $option_key, 0, 3 ) === "fan")
		    {
			    $stats['fans'][$option_key] = $miner_stats[$option_key];
		    }

		    if(substr( $option_key, 0, 9 ) === "chain_acn")
		    {
			    $chain_index = substr( $option_key, -1, 1 );

			    $brd_chips_var = 'chain_acn'.$chain_index;
			    $brd_chips_stat_var = 'chain_acs'.$chain_index;


			    $stats['chains'][$chain_index]['chips'] = $miner_stats[$brd_chips_var];
			    $stats['chains'][$chain_index]['chips_stat'] = str_split(str_replace(' ', '', $miner_stats[$brd_chips_stat_var]));

			    foreach($stats['chains'][$chain_index]['chips_stat'] as $chip)
			    {
				    if($chip == 'o')
				    {
					    $chip_ok_count++;
				    }
				    else
				    {
					    $chip_er_count++;
				    }
			    }

			    $stats['chains'][$chain_index]['chips_condition']['ok'] = $chip_ok_count;
			    $stats['chains'][$chain_index]['chips_condition']['er'] = $chip_er_count;

			    $chip_ok_count = 0;
			    $chip_er_count = 0;



			    if($antMiner->type == 'bmminer')
			    {
				    $brd1_temp_var = 'temp2_'.$chain_index;
				    $brd2_temp_var = 'temp3_'.$chain_index;

				    $brd_freq_var = 'freq_avg'.$chain_index;

				    $stats['chains'][$chain_index]['brd_temp1'] = $miner_stats[$brd1_temp_var];
				    $stats['chains'][$chain_index]['brd_temp2'] = $miner_stats[$brd2_temp_var];
				    $stats['chains'][$chain_index]['brd_freq']  = $miner_stats[$brd_freq_var];
			    }
			    else
			    {
				    $brd_temp_var = 'temp'.$chain_index;
				    $stats['chains'][$chain_index]['brd_temp'] = $miner_stats[$brd_temp_var];
				    $stats['chains'][$chain_index]['brd_freq']  = $miner_stats['frequency'];
			    }


		    }
	    }

	    return $stats;
    }

}

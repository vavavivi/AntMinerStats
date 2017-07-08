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

class AntMinerController extends AppBaseController
{
    /** @var  AntMinerRepository */
    private $antMinerRepository;

    public function __construct(AntMinerRepository $antMinerRepo)
    {
        $this->antMinerRepository = $antMinerRepo;
    }

    /**
     * Display a listing of the AntMiner.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->antMinerRepository->pushCriteria(new RequestCriteria($request));
        $antMiners = $this->antMinerRepository->all();

        return view('ant_miners.index')
            ->with('antMiners', $antMiners);
    }

    /**
     * Show the form for creating a new AntMiner.
     *
     * @return Response
     */
    public function create()
    {
        return view('ant_miners.create');
    }

    /**
     * Store a newly created AntMiner in storage.
     *
     * @param CreateAntMinerRequest $request
     *
     * @return Response
     */
    public function store(CreateAntMinerRequest $request)
    {
        $input = $request->all();

        $antMiner = $this->antMinerRepository->create($input);

        Flash::success('Ant Miner saved successfully.');

        return redirect(route('antMiners.edit',$antMiner->id));
    }

    /**
     * Display the specified AntMiner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $antMiner = $this->antMinerRepository->findWithoutFail($id);

        if (empty($antMiner)) {
            Flash::error('Ant Miner not found');

            return redirect(route('antMiners.index'));
        }

        //return $this->run_ssh_command($antMiner, '/usr/bin/bmminer-api -o pools');

        $stats_all = $this->getStats($antMiner);

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

	    $keys = [];

	    $stats_all = $this->getStats($antMiner);
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

        $this->antMinerRepository->delete($id);

        Flash::success('Ant Miner deleted successfully.');

        return redirect(route('antMiners.index'));
    }

    private function get_ssh_stats(AntMiner $antMiner)
    {
	    $ssh_host = $antMiner->host;
	    $ssh_port = $antMiner->port;
	    $ssh_auth_user = $antMiner->username;
	    $ssh_auth_pass = $antMiner->password;

	    ini_set("default_socket_timeout", 25);


	    if (!($connection = ssh2_connect($ssh_host, $ssh_port))) {
		    abort(500, 'Cannot connect to server');
	    }

	    if(!(ssh2_auth_password($connection, $ssh_auth_user, $ssh_auth_pass))) {
		    abort(500, 'Username or Password invalid');
	    }

	    $command_summary = '/usr/bin/'.$antMiner->type.'-api -o summary';
	    $stream_summary = ssh2_exec($connection, $command_summary);
	    stream_set_blocking($stream_summary, true);

	    $data = "";
	    while ($buf = fread($stream_summary, 4096)) {
		    $data .= $buf;
	    }
	    fclose($stream_summary);

	    $reply['summary'] = $data;

	    $command_stats = '/usr/bin/'.$antMiner->type.'-api -o stats';
	    $stream_stats = ssh2_exec($connection, $command_stats);
	    stream_set_blocking($stream_stats, true);

	    $data = "";
	    while ($buf = fread($stream_stats, 4096)) {
		    $data .= $buf;
	    }
	    fclose($stream_stats);

	    $reply['stats'] = $data;

	    $command_pools = '/usr/bin/'.$antMiner->type.'-api -o pools';
	    $stream_pools = ssh2_exec($connection, $command_pools);
	    stream_set_blocking($stream_pools, true);

	    $data = "";
	    while ($buf = fread($stream_pools, 4096)) {
		    $data .= $buf;
	    }
	    fclose($stream_pools);
	    $reply['pools'] = $data;

	    ssh2_exec($connection, 'echo "EXITING" && exit;');
	    $connection = null;

	    return $reply;
    }

    private function getStats(AntMiner $antMiner)
    {
	    $reply_raw = $this->get_ssh_stats($antMiner);

	    return $reply_raw;
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
}

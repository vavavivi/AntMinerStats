<?php

namespace App\Console\Commands;

use App\Models\AntMiner;
use App\Traits\MinerTrait;
use Illuminate\Console\Command;
use Telegram;

class PollMiner extends Command
{
    use MinerTrait;

    protected $signature = 'antminer:poll';

    protected $description = 'Poll miner data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $antMiners = AntMiner::all();
        $s = 0;
        $f = 0;
        foreach($antMiners as $antMiner)
        {
            $miner_data = $this->formatMinerData($antMiner);

            if($miner_data)
            {
	            if($antMiner->type == 'bmminer')
	            {
		            $data['hr']  = intval (round($miner_data['hash_rate'],0));
		            $i = 1;
		            foreach($miner_data['chains'] as $chain_id => $chain)
		            {
			            $data['temp'.$i]  = intval ($chain['brd_temp1']);
			            $data['temp'.$i.'1'] = intval ($chain['brd_temp2']);
			            $data['freq'.$i]  = intval ($chain['brd_freq']);
			            $i++;

		            }

		            $antMiner->antlogs()->create($data);

		            $data = null;
	            }
	            else
	            {
		            $data['hr']  = intval (round($miner_data['hash_rate'],0));
		            $i = 1;
		            foreach($miner_data['chains'] as $chain_id => $chain)
		            {
			            $data['temp'.$i]  = intval ($chain['brd_temp']);
			            $data['temp'.$i.'1'] = null;
			            $data['freq'.$i]  = intval ($chain['brd_freq']);
			            $i++;
		            }

		            $antMiner->antlogs()->create($data);

		            $data = null;
	            }

	            $s++;
            }
            else
            {
            	$f++;

            	$chat_id = $antMiner->user->chat_id;

            	if($chat_id)
	            {
		            $msg = $antMiner->title .' is offline or unable to connect.';

		            Telegram::sendMessage([
			            'chat_id' => 2421164,
			            'text' => $msg,
			            'parse_mode' =>'HTML'
		            ]);
	            }

            }
        }

        $msg = $s ." Miners were polled. ".$f ." Miners failed to fetch.\n";

        echo  $msg;

    }
}
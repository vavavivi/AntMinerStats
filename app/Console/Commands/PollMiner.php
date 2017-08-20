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
        $a = 0;
        foreach($antMiners as $antMiner)
        {
	        $chat_id = $antMiner->user->chat_id;

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

	            }

	            if(! key_exists('temp3',$data))
	            {
	            	$data['temp3'] = 0;
	            }

	            if(! key_exists('temp2',$data))
	            {
		            $data['temp2'] = 0;
	            }

	            if(! key_exists('freq3',$data))
	            {
		            $data['freq3'] = 0;
	            }

	            if(! key_exists('freq2',$data))
	            {
		            $data['freq2'] = 0;
	            }



	            $antMiner->antlogs()->create($data);
	            $last_hr = $data['hr'];

	            $data = null;

	            $s++;

	            if($antMiner->type == 'bmminer' && $last_hr < 10000 && $chat_id)
	            {
		            $msg = $antMiner->title .' low HR alert:'.$last_hr;

		            Telegram::sendMessage([
			            'chat_id' => $chat_id,
			            'text' => $msg,
			            'parse_mode' =>'HTML'
		            ]);

		            $a++;
	            }
	            elseif($antMiner->type == 'cgminer' && $last_hr < 3500 && $chat_id)
	            {
		            $msg = $antMiner->title .' low HR alert:'.$last_hr;

		            Telegram::sendMessage([
			            'chat_id' => $chat_id,
			            'text' => $msg,
			            'parse_mode' =>'HTML'
		            ]);

		            $a++;
	            }

	            else
	            {

	            }


            }
            else
            {
            	$f++;

            	if($chat_id)
	            {
		            $msg = $antMiner->title .' is offline or unable to connect.';

		            Telegram::sendMessage([
			            'chat_id' => $chat_id,
			            'text' => $msg,
			            'parse_mode' =>'HTML'
		            ]);

		            $a++;
	            }

            }

        }

        $msg = $s ." Miners were polled. ".$f ." Miners failed to fetch.". $a." alerts were send.\n";

        echo  $msg;

    }
}

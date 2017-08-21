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

		        if(! key_exists('temp3',$data)) $data['temp3'] = 0;
		        if(! key_exists('temp2',$data)) $data['temp2'] = 0;
		        if(! key_exists('freq3',$data)) $data['freq3'] = 0;
		        if(! key_exists('freq2',$data)) $data['freq2'] = 0;

		        $antMiner->antlogs()->create($data);

		        if($chat_id)
		        {
			        if($antMiner->hr_limit && $data['hr'] < $antMiner->hr_limit)
			        {
				        $msg = $antMiner->title .' low Hashrate alert: <b>'.round($data['hr']/1000,2).' Th</b> Your limit is: <b>'.round($antMiner->hr_limit/1000,2).' Th</b>';

				        Telegram::sendMessage([
					        'chat_id' => $chat_id,
					        'text' => $msg,
					        'parse_mode' =>'HTML'
				        ]);

				        $a++;

				        //Restart Experemental. Requires Write Access to miner via cgminer.conf

				        if($data['hr'] == 0 && $antMiner->restart )
				        {
					        $resp = $this->read_from_socket($antMiner, 'restart');

					        $msg = 'Trying to restart '. $antMiner->title .' due to <b>0</b> hashrate. Restart cmd result: '.$resp;

					        Telegram::sendMessage([
						        'chat_id' => $chat_id,
						        'text' => $msg,
						        'parse_mode' =>'HTML'
					        ]);

					        $a++;
				        }
			        }

			        if($antMiner->temp_limit)
			        {
				        $max_temp = 0;

				        if(key_exists('temp1',$data) && $data['temp1'] > $antMiner->temp_limit) $max_temp = $data['temp1'];
				        if(key_exists('temp2',$data) && $data['temp2'] > $antMiner->temp_limit && $data['temp2'] > $max_temp ) $max_temp = $data['temp2'];
				        if(key_exists('temp3',$data) && $data['temp3'] > $antMiner->temp_limit && $data['temp3'] > $max_temp ) $max_temp = $data['temp3'];

				        if(key_exists('temp11',$data) && $data['temp11'] > $antMiner->temp_limit && $data['temp11'] > $max_temp ) $max_temp = $data['temp11'];
				        if(key_exists('temp21',$data) && $data['temp21'] > $antMiner->temp_limit && $data['temp21'] > $max_temp ) $max_temp = $data['temp21'];
				        if(key_exists('temp31',$data) && $data['temp31'] > $antMiner->temp_limit && $data['temp31'] > $max_temp ) $max_temp = $data['temp31'];


				        if($max_temp > 0)
				        {
					        $msg = $antMiner->title .' high temperature alert: <b>'.$max_temp.'C</b> Your limit is: <b>'.$antMiner->temp_limit.'C</b>';


					        Telegram::sendMessage([
						        'chat_id' => $chat_id,
						        'text' => $msg,
						        'parse_mode' =>'HTML'
					        ]);

					        $a++;
				        }

			        }
		        }

		        $data = null;
		        $s++;


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

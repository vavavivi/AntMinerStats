<?php

namespace App\Console\Commands;

use App\Models\Alert;
use App\Models\AntMiner;
use App\Traits\MinerTrait;
use Carbon\Carbon;
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
	    $antMiners = AntMiner::active()->get();
	    $s = 0; // success count
	    $f = 0; // failure count
	    $a = 0; // alerts count
	    $msg = []; //Message array

	    foreach($antMiners as $antMiner)
	    {
		    $chat_id = $antMiner->user->chat_id;
		    $miner_data = $this->formatMinerData($antMiner);

		    if( $miner_data )
		    {
			    if( $antMiner->antlogs->count() > 1440 )
			    {
				    foreach($antMiner->antlogs->take($antMiner->antlogs->count() - 1440) as $log)
				    {
					    $log->delete();
				    }
			    }

			    $antMiner->antlogs()->create($miner_data);

			    if( $antMiner->hr_limit && $miner_data['hash_rate'] < $antMiner->hr_limit )
			    {
				    $msg[] = $antMiner->title . ' low Hashrate alert: <b>' . round($miner_data['hash_rate'] / 1024, 2) . ' Th</b> Your limit is: <b>' . round($antMiner->hr_limit / 1024, 2) . ' Th</b>';
				    if( $miner_data['hash_rate'] < 500 && $antMiner->restart )
				    {
					    $resp = $this->read_from_socket($antMiner, 'restart');
					    $msg[] = 'Trying to restart ' . $antMiner->title . ' due to <b>0</b> hashrate. Restart cmd result: ' . $resp;
				    }
			    }

			    if( $antMiner->temp_limit )
			    {
				    $max_temp = 0;
				    foreach($miner_data['chains'] as $chain)
				    {
					    foreach($chain['brd_temp'] as $cur_temp)
					    {
						    if( $cur_temp > $max_temp )
						    {
							    $max_temp = $cur_temp;
						    }
					    }
				    }

				    if( $max_temp > $antMiner->temp_limit )
				    {
					    $msg[] = $antMiner->title . ' high temperature alert: <b>' . $max_temp . 'C</b> Your limit is: <b>' . $antMiner->temp_limit . 'C</b>';
				    }

			    }

			    $data = null;
			    $s++;

			    $antMiner->update(['f_count' => 0]);

		    } else
		    {
			    $f++;
			    $msg[] = $antMiner->title . ' is offline or unable to connect.';
			    $antMiner->increment('f_count');
			    if( $antMiner->f_count >= 5 )
			    {
				    $reason = 'Auto disabled due to 5 unsuccessful attempts to connect to ASIC in a row on : ' . Carbon::now()->format('d.m.Y H:i:s');
				    $msg[] = $reason;
				    $antMiner->update([
					    'active'   => false,
					    'd_reason' => $reason,
					    'f_count'  => 0,
				    ]);
			    }
		    }

		    foreach($msg as $message)
		    {
			    Alert::create([
				    'user_id'      => $antMiner->user->id,
				    'ant_miner_id' => $antMiner->id,
				    'subject'      => '',
				    'body'         => $message,
				    'status'       => 'new',
			    ]);

			    if( $chat_id )
			    {
				    Telegram::sendMessage([
					    'chat_id'    => $chat_id,
					    'text'       => $message,
					    'parse_mode' => 'HTML',
				    ]);
			    }

			    $a++;
		    }
		    $msg = [];
	    }
	    $console_res = $s . " Miners were polled. " . $f . " Miners failed to fetch." . $a . " alerts were send.\n";

	    echo $console_res;
    }
}

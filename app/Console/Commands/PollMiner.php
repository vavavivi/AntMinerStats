<?php

namespace App\Console\Commands;

use App\Jobs\PollMinerQ;
use App\Models\AntMiner;
use App\Traits\MinerTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PollMiner extends Command
{
    use MinerTrait;

    protected $signature = 'antminer:poll';

    protected $description = 'Create jobs for polling data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
	    $antMiners = AntMiner::active()->get();

	    $count = $antMiners->count();

	    $chunks = floor($count / 5) + 1;

	    $seconds_delay = 0;

	    foreach($antMiners->chunk($chunks) as $antMiners_chunked)
	    {
	    	foreach($antMiners_chunked as $antMiner)
		    {
			    PollMinerQ::dispatch($antMiner)->delay(Carbon::now()->addSeconds($seconds_delay));
		    }

		    $seconds_delay = $seconds_delay + 60;
	    }

	    echo 'OK';
    }
}

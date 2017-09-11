<?php

namespace App\Console\Commands;

use App\Jobs\PollMinerQ;
use App\Models\AntMiner;
use App\Traits\MinerTrait;
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

	    foreach($antMiners as $antMiner)
	    {
		    PollMinerQ::dispatch($antMiner);
	    }

	    echo 'OK';
    }
}

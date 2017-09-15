<?php

namespace App\Jobs;

use App\Models\Alert;
use App\Models\AntMiner;
use App\Traits\MinerTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Telegram;

class PollMinerQ implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, MinerTrait;

	protected $antMiner;


    public function __construct(AntMiner $antMiner)
    {
	    $this->antMiner = $antMiner;
    }

    public function handle()
    {
	    $antMiner = $this->antMiner;

	    $miner_data = $this->formatMinerData($antMiner);

	    $antMinerLog = $this->storeLog($miner_data, $antMiner);

	    $this->analizeLog($antMinerLog, $antMiner);
    }
}

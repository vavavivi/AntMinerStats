<?php

namespace App\Console\Commands;

use App\Models\AntMiner;
use App\Traits\MinerTrait;
use Illuminate\Console\Command;

class PollMiner extends Command
{
    use MinerTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antminer:poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll miner data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $antMiners = AntMiner::all();
        $i = 0;
        foreach($antMiners as $antMiner)
        {
            $miner_data = $this->formatMinerData($antMiner);
            $antMiner->antMinerlogs()->create(['data'=>$miner_data]);
            $i++;
        }

        echo  $i .' Miners were polled.';
    }
}

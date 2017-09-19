<?php

namespace App\Jobs;

use App\Models\Alert;
use App\Models\AntMiner;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Telegram;

class SendAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $antMiner;
	protected $message;

    public function __construct(AntMiner $antMiner, $message)
    {
	    $this->antMiner = $antMiner;
	    $this->message = $message;
    }

    public function handle()
    {
	    Alert::create([
		    'user_id'      => $this->antMiner->user->id,
		    'ant_miner_id' => $this->antMiner->id,
		    'subject'      => '',
		    'body'         => $this->message,
		    'status'       => 'new',

	    ]);

	    if( $this->antMiner->user->chat_id)
	    {
		    Telegram::sendMessage([
			    'chat_id'    => $this->antMiner->user->chat_id,
			    'text'       => $this->message,
			    'parse_mode' => 'HTML',
			    'disable_web_page_preview' => true
		    ]);
	    }
    }
}

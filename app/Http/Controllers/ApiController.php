<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;

class ApiController extends Controller
{
    public function webHook()
    {
	    $response = Telegram::setWebhook(['url' => 'https://ant.hippie.com.ua/api/webhook']);

	    return $response;

    }

    public function sendInfo()
    {
	    $a = '';



	    foreach($antMiners as $antMiner)
	    {
		    $a .= '<b>'.$antMiner->title.'</b>:
';
		    $a .= 'Hashrate: <i>'.$data[$antMiner->id]['hash_rate'].' Ghs</i>
';
		    $a .= 'AVG Temp: <i>'.$data[$antMiner->id]['temp_avg'].' Ghs</i>
';
		    $a .= 'Chips OK: <i>'.$data[$antMiner->id]['chips']['ok'].'</i>
';
		    $a .= 'Chips Failed: <i>'.$data[$antMiner->id]['chips']['er'].'</i>
';
		    $a .= 'FAN1: <i>'.$data[$antMiner->id]['fans'][0].' rpm</i>
';
		    $a .= 'FAN2: <i>'.$data[$antMiner->id]['fans'][1].' rpm</i>
';
		    $a .= '
';

	    }



	    $telegram->sendMessage([
		    'chat_id' => 2421164,
		    'text' => $a,
		    'parse_mode' =>'HTML'
	    ]);


	    $telegram->sendMessage([
		    'chat_id' => 81184145,
		    'text' => $a,
		    'parse_mode' =>'HTML'
	    ]);
    }
}

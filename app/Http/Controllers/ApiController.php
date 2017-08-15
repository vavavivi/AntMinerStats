<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;

class ApiController extends Controller
{
    public function set_webhook()
    {
	    $response = Telegram::setWebhook(['url' => 'https://ant.hippie.com.ua/api/webhook']);

	    return $response;

    }

    public function webhook(Request $request)
    {
    	$hook = $request->all();

    	$chat_id = $hook['message']['from']['id'];

	    $i = Telegram::getMe();
	    $msg = json_encode($hook);

	    $msg = 'Welcome to antMiner notify service. Your chat ID is:<strong>'.$chat_id.'</strong>. 
				Please fill chat id in your <a href="https://antminer.dev/profile">profile</a>.
	    ';


	    $response = Telegram::sendMessage([
		    'chat_id' => $chat_id,
		    'text' => $msg
	    ]);

    }

    public function sendInfo()
    {
	    Telegram::sendMessage([
		    'chat_id' => 2421164,
		    'text' => 123,
		    'parse_mode' =>'HTML'
	    ]);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;

class ApiController extends Controller
{
    public function set_webhook()
    {
	    $response = Telegram::setWebhook(['url' => route('webHook')]);

	    return $response;

    }

    public function webhook(Request $request)
    {
    	$hook = $request->all();

    	$chat_id = $hook['message']['from']['id'];

	    $msg = 'Welcome to antMiner notify service. Your chat ID is: <strong>'.$chat_id.'</strong>. 
				Please fill chat id in your <a href="'.route('profile').'">profile</a>.
	    ';

	    Telegram::sendMessage([
		    'chat_id' => $chat_id,
		    'text' => $msg,
		    'parse_mode' =>'HTML'
	    ]);

    }

}

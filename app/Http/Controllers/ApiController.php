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
	    $i = Telegram::getMe();
	    $msg = json_encode($i);


	    $response = Telegram::sendMessage([
		    'chat_id' => 2421164,
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

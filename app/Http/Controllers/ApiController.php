<?php

namespace App\Http\Controllers;

use App\Telegram\Commands\StartCommand;
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

	    $update = Telegram::commandsHandler(true);

	    // Commands handler method returns an Update object.
	    // So you can further process $update object
	    // to however you want.

	    return 'ok';

    }

}

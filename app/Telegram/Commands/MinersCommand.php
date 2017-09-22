<?php

namespace App\Telegram\Commands;

use App\User;
use Telegram;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class MinersCommand extends Command
{
	protected $name = "miners";

	protected $description = "List of Antminers";

	public function handle($arguments)
	{
		$keyboard = [];

		$chat_id = $this->update->getMessage()->getChat()->getId();

		$user = User::where('chat_id',$chat_id)->get();

		if(! $user)
		{
			Telegram::sendMessage([
				'chat_id' => $this->update->getMessage()->getChat()->getId(),
				'text' => 'No user found',
			]);

			return 'ok';
		}

		$antminers = $user->miners;

		if($antminers->count() == 0)
		{
			Telegram::sendMessage([
			'chat_id' => $this->update->getMessage()->getChat()->getId(),
			'text' => 'No antminers found',
			]);

			return 'ok';
		}


		$i = 0;

		foreach($antminers->chunk(3) as $antMiners_chunked)
		{
			foreach($antMiners_chunked as $antMiner)
			{
				$keyboard[$i][] = $antMiner->title;
			}

			$i++;

		}

		$reply_markup = Telegram::replyKeyboardMarkup([
			'keyboard' => $keyboard,
			'resize_keyboard' => true,
			'one_time_keyboard' => true
		]);

		Telegram::sendMessage([
			'chat_id' => $this->update->getMessage()->getChat()->getId(),
			'text' => 'Hello World',
			'reply_markup' => $reply_markup
		]);

	}
}
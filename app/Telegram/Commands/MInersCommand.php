<?php

namespace App\Telegram\Commands;

use Telegram;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class MinersCommand extends Command
{
	/**
	 * @var string Command Name
	 */
	protected $name = "miners";

	/**
	 * @var string Command Description
	 */
	protected $description = "List of your miners";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments)
	{
		$chat_id = $this->update->getMessage()->getChat()->getId();

		$keyboard = [
			['7', '8', '9'],
			['4', '5', '6'],
			['1', '2', '3'],
			['0']
		];

		$reply_markup = Telegram::replyKeyboardMarkup([
			'keyboard' => $keyboard,
			'resize_keyboard' => true,
			'one_time_keyboard' => true
		]);

		Telegram::sendMessage([
			'chat_id' => $chat_id,
			'text' => 'Hello World',
			'reply_markup' => $reply_markup
		]);

	}
}
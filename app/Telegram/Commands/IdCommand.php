<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class IdCommand extends Command
{
	/**
	 * @var string Command Name
	 */
	protected $name = "id";

	/**
	 * @var string Command Description
	 */
	protected $description = "Gives you chat ID for sync with antstats profile";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments)
	{
		$chat_id = $this->update->getMessage()->getChat()->getId();

		$msg = 'Welcome to antMiner notify service. Your chat ID is: <strong>'.$chat_id.'</strong>. 
			Please fill chat id in your <a href="'.route('profile').'">profile</a>.
    	';

		$this->replyWithChatAction(['action' => Actions::TYPING]);
		$this->replyWithMessage(['text' => $msg,'parse_mode' => 'HTML']);

	}
}
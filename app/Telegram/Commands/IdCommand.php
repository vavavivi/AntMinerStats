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
		$start_text = json_encode($this);

		$this->replyWithChatAction(['action' => Actions::TYPING]);
		$this->replyWithMessage(['text' => $arguments]);

	}
}
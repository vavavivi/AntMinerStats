<?php

namespace App\Telegram\Commands;

use Telegram;
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


	}
}
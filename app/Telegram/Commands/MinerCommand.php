<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class MinerCommand extends Command
{
	protected $name = "miner";

	protected $description = "List of Antminers";

	public function handle($arguments)
	{
		$this->replyWithMessage(['text' => 'Hello!']);
		$this->replyWithChatAction(['action' => Actions::TYPING]);
	}
}
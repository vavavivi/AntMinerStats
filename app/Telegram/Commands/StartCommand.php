<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
	/**
	 * @var string Command Name
	 */
	protected $name = "start";

	/**
	 * @var string Command Description
	 */
	protected $description = "Start Command to get you started";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments)
	{
		$start_text = 'Hello! Welcome to antstats.info bot notifier, Here are our available commands:';

		$this->replyWithMessage(['text' => $start_text]);
		$this->replyWithChatAction(['action' => Actions::TYPING]);

		$commands = $this->getTelegram()->getCommands();

		$response = '';
		foreach ($commands as $name => $command) {
			$response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
		}

		$this->replyWithMessage(['text' => $response]);
	}
}
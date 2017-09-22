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
	protected $description = "Sync your antstats.info account with telegram bot";

	/**
	 * @inheritdoc
	 */
	public function handle($arguments)
	{
		$chat_id = $this->update->getMessage()->getChat()->getId();
		$msg = 'To sync your antstats account with telegram bot, please visit your <a href="'.route('profile').'">🔗 profile</a> and fill <strong>Telegram Chat ID</strong> field with ID: <strong>'.$chat_id.'</strong>';

		$this->replyWithChatAction(['action' => Actions::TYPING]);
		$this->replyWithMessage(['text' => $msg,'parse_mode' => 'HTML','disable_web_page_preview' => true]);
	}
}
<?php

declare(strict_types=1);

namespace ClickedTran\GiftCode\command\subcmd;

use CortexPE\Commando\BaseSubCommand;

use pocketmine\command\CommandSender;

class HelpGiftCodeCommand extends BaseSubCommand {

	protected function prepare(): void {
		$this->setPermission("giftcode.command.help");
	}

	public function onRun(CommandSender $sender, String $labelUsed, array $args): void {
		$sender->sendMessage("   §6> §b§lAll GiftCode Command §6<");
		$sender->sendMessage("§b/giftcode help §7- All GiftCode command!");
		$sender->sendMessage("§b/giftcode create §7- Create GiftCode to data");
		$sender->sendMessage("§b/giftcode remove §7- Remove GiftCode in data");
		$sender->sendMessage("§b/giftcode list §7- List all GiftCode in data");
	}
}

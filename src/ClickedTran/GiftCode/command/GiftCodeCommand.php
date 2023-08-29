<?php

declare(strict_types=1);

namespace ClickedTran\GiftCode\command;

use pocketmine\Server;
use pocketmine\player\Player;
use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;

use ClickedTran\GiftCode\command\subcmd\HelpGiftCodeCommand;
use ClickedTran\GiftCode\command\subcmd\CreateGiftCodeCommand;
use ClickedTran\GiftCode\command\subcmd\RemoveGiftCodeCommand;
use ClickedTran\GiftCode\command\subcmd\ListGiftCodeCommand;
use ClickedTran\GiftCode\form\FormManager;

class GiftCodeCommand extends BaseCommand {

	public function prepare(): void {
		$this->setPermission("giftcode.command");
		$this->registerSubcommand(new HelpGiftCodeCommand("help", "Help GiftCode Command"));
		$this->registerSubcommand(new CreateGiftCodeCommand("create", "Create GiftCode Command"));
		$this->registerSubcommand(new RemoveGiftCodeCommand("remove", "Remove GiftCode Command"));
		$this->registerSubcommand(new ListGiftCodeCommand("list", "List All GiftCode"));
	}

	public function onRun(CommandSender $sender, String $labelUsed, array $args): void {
		if (!$sender instanceof Player) {
			$sender->sendMessage("§9[ §4ERROR §9] §aPlease use in-game");
			return;
		}
		if (count($args) == 0) {
			if (!Server::getInstance()->isOp($sender->getName()) && !$sender->hasPermission("giftcode.command.menu")) {
				$form = new FormManager();
				$sender->sendForm($form->menuEnterCode($sender));
			} else {
				$form = new FormManager();
				$sender->sendForm($form->menuGiftCode($sender));
			}
		}
	}
}

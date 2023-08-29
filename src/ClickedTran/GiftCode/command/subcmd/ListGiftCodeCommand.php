<?php

declare(strict_types=1);

namespace ClickedTran\GiftCode\command\subcmd;

use CortexPE\Commando\BaseSubCommand;

use pocketmine\command\CommandSender;

use ClickedTran\GiftCode\GiftCode;

class ListGiftCodeCommand extends BaseSubCommand {

	protected function prepare(): void {
		$this->setPermission("giftcode.command.list");
	}

	public function onRun(CommandSender $sender, String $labelUsed, array $args): void {
		$all_giftcode = GiftCode::getInstance()->getCode()->getAll();
		if ($all_giftcode == null) {
			$sender->sendMessage("§9[ §4ERROR §9] §cThe list of giftcodes is empty!");
		}
		foreach ($all_giftcode as $code => $key) {
			$exprire = $key["exprire"];
			$sender->sendMessage("§l§aGiftcode §7" . $code . "§l§a with expiration time: §f" . $exprire["day"] . " §9day §f" . $exprire["hour"] . " §9hour §f" . $exprire["minute"] . " §9minute §f" . $exprire["second"] . " §9second!");
		}
	}
}

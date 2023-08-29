<?php

namespace ClickedTran\GiftCode\command\subcmd;

use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\args\RawStringArgument;

use ClickedTran\GiftCode\GiftCode;

class CreateGiftCodeCommand extends BaseSubCommand {

	protected function prepare(): void {
		$this->setPermission("giftcode.command.create");
		$this->registerArgument(0, new RawStringArgument("giftcode", true));
		$this->registerArgument(1, new IntegerArgument("day", true));
		$this->registerArgument(2, new IntegerArgument("hour", true));
		$this->registerArgument(3, new IntegerArgument("minute", true));
		$this->registerArgument(4, new IntegerArgument("second", true));
		$this->registerArgument(5, new RawStringArgument("type", true));
		$this->registerArgument(6, new IntegerArgument("amount", true));
	}

	public function onRun(CommandSender $sender, String $labelUsed, array $args): void {
		if (GiftCode::getInstance()->getCode()->exists($args["giftcode"])) {
			$sender->sendMessage("§9[ §4ERROR §9] §cGiftcode already exist. Try again!");
			return;
		}
		if (!isset($args["giftcode"])) {
			$sender->sendMessage("§9[ §4ERROR §9] §cPlease add giftcode");
			return;
		}
		if (!is_numeric($args["day"])) {
			$sender->sendMessage("§9[ §4ERROR §9] §cPlease add day expired for giftcode");
			return;
		}
		if (!is_numeric($args["hour"]) or $args["hour"] > 24) {
			$sender->sendMessage("§9[ §4ERROR §9] §cPlease add hour expired for giftcode. Max number is §724!");
			return;
		}
		if (!is_numeric($args["minute"]) or $args["minute"] > 60) {
			$sender->sendMessage("§9[ §4ERROR §9] §cPlease add minute expired for giftcode. Max number is §760!");
			return;
		}
		if (!is_numeric($args["second"]) or $args["second"] > 60) {
			$sender->sendMessage("§9[ §4ERROR §9] §cPlease add second expired for giftcode. Max number is §760!");
			return;
		}
		if (!isset($args["type"]) or ($args["type"] != "EconomyAPI" and
		/**$args["type"] != "PointAPI" and $args["type"] != "CoinAPI" and*/
		$args["type"] != "BedrockEconomy")) {
			$sender->sendMessage("§9[ §4ERROR §9] §cPlease choose type. All types are available: §7EconomyAPI, BedrockEconomy");
			return;
		}
		if (!is_numeric($args["amount"])) {
			$sender->sendMessage("§9[ §4ERROR §9] §cPlease add amount for reward giftcode!");
			return;
		}
		GiftCode::getInstance()->createCode($args["giftcode"], (int)$args["day"], (int)$args["hour"], (int)$args["minute"], (int)$args["second"], $args["type"], (int)$args["amount"]);
		$sender->sendMessage("§9[ §eSuccessfully §9] §aYou created code §7" . $args["giftcode"] . " §awith time: §7" . $args["day"] . " §9day, §7" . $args["hour"] . " §9hour, §7" . $args["minute"] . " §9minute, §7" . $args["second"] . " §9second §aand type of reward §b" . $args["type"] . " §awith amount §7" . $args["amount"]);
	}
}

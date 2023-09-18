<?php

namespace ClickedTran\GiftCode\command\subcmd;

use pocketmine\player\Player;
use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\exception\ArgumentOrderException;

use ClickedTran\GiftCode\GiftCode;

class RemoveGiftCodeCommand extends BaseSubCommand {
  
  protected function prepare() : void{
    $this->setPermission("giftcode.command.remove");
    $this->registerArgument(0, new RawStringArgument("giftcode", true));
  }
  
  public function onRun(CommandSender $sender, String $labelUsed, Array $args) : void{
    if(!isset($args["giftcode"])){
       $sender->sendMessage("§9[ §4ERROR §9] §cPlease input giftcode name needs to be deleted!");
       return;
    }
    if(!GiftCode::getInstance()->getCode()->exists($args["giftcode"])){
       $sender->sendMessage("§9[ §4ERROR §9] §cGiftcode does not exist, please check and try again");
       return;
    }
    GiftCode::getInstance()->removeCode($args["giftcode"]);
    $sender->sendMessage("§9[ §eSuccessfully §9]§a You deleted the giftcode §7" . $args["giftcode"] . " §afrom data");
  }
}

<?php

namespace ClickedTran\GiftCode\command\subcmd;

use pocketmine\player\Player;
use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\exception\ArgumentOrderException;

use ClickedTran\GiftCode\GiftCode;

class CreateGiftCodeCommand extends BaseSubCommand {
  
  protected function prepare() : void{
    $this->setPermission("giftcode.command.create");
    $this->registerArgument(0, new RawStringArgument("giftcode", true));
    $this->registerArgument(1, new IntegerArgument("day", true));
    $this->registerArgument(2, new IntegerArgument("hour", true));
    $this->registerArgument(3, new IntegerArgument("minute", true));
    $this->registerArgument(4, new IntegerArgument("second", true));
    $this->registerArgument(5, new RawStringArgument("command", true));
  }
  
  public function onRun(CommandSender $sender, String $labelUsed, Array $args) : void{
    if(!isset($args["giftcode"])){
       $sender->sendMessage("§9[ §4ERROR §9] §cPlease input new giftcode");
       return;
    }
    if(GiftCode::getInstance()->getCode()->exists($args["giftcode"])){
       $sender->sendMessage("§9[ §4ERROR §9] §cGiftcode already exist. Try again!");
       return;
    }
    if(!is_numeric($args["day"])){
       $sender->sendMessage("§9[ §4ERROR §9] §cPlease add day expired for giftcode");
       return;
    }
    if(!is_numeric($args["hour"]) or $args["hour"] > 24){
       $sender->sendMessage("§9[ §4ERROR §9] §cPlease add hour expired for giftcode. Max number is §724!");
       return;
    }
    if(!is_numeric($args["minute"]) or $args["minute"] > 60){
       $sender->sendMessage("§9[ §4ERROR §9] §cPlease add minute expired for giftcode. Max number is §760!");
       return;
    }
    if(!is_numeric($args["second"]) or $args["second"] > 60){
       $sender->sendMessage("§9[ §4ERROR §9] §cPlease add second expired for giftcode. Max number is §760!");
       return;
    }
    if(!isset($args["command"])){
       $sender->sendMessage("§9[ §4ERROR §9]§r§c Please input command!");
       return;
    }
    
    GiftCode::getInstance()->createCode($args["giftcode"], (int)$args["day"], (int)$args["hour"], (int)$args["minute"], (int)$args["second"], $args["command"]);
    $sender->sendMessage("§9[ §eSuccessfully §9] You created code §7". strtolower($args["giftcode"])." §awith time: §7".$args["day"]." §9day, §7".$args["hour"]." §9hour, §7".$args["minute"]." §9minute, §7".$args["second"]." §9second §awith command §b". $args["command"]);
  }
}

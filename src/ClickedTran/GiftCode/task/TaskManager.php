<?php
declare(strict_types=1);

namespace ClickedTran\GiftCode\task;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\scheduler\Task;

use ClickedTran\GiftCode\GiftCode;

class TaskManager extends Task {
  /** @var GiftCode $plugin*/
  public GiftCode $plugin;
  
  public function __construct(GiftCode $plugin){
    $this->plugin = $plugin;
  }
  
  public function onRun() : void{
    $giftcode = $this->plugin->getCode();
    foreach($giftcode->getAll() as $code => $key){
    if($giftcode->exists($code)){
      $type = $key["type"];
      $amount = $key["amount"];
      $playerUsed = $key["player-used"];
      $exprire = $key["exprire"];
      $day = $exprire["day"];
      $hour = $exprire["hour"];
      $minute = $exprire["minute"];
      $second = $exprire["second"];
      
      if($hour == 0 && $day > 0){
         $hour = 24;
         $day = $day - 1;
      }
      
      if($minute == 0 && $hour > 0){
         $minute = 59;
         $hour = $hour - 1;
      }
      
      if($second == 0 && $minute > 0){
         $second = 60;
         $minute = $minute - 1;
      }
      if($day == 0 && $hour == 0 && $minute == 0 && $second == 0){
         $this->plugin->removeCode($code);
         break;
      }
      $second = $second - 1;
      $giftcode->set($code, 
      ["exprire" => ["day" => $day, 
                     "hour" => $hour,
                     "minute" => $minute,
                     "second" => $second],
      "type" => $type,
      "amount" => $amount,
      "player-used" => $playerUsed
      ]);
      $giftcode->save();
     }
    }
  }
}

<?php
declare(strict_types=1);

namespace ClickedTran\GiftCode\form;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\console\ConsoleCommandSender;

use ClickedTran\GiftCode\GiftCode;

# <-- Form Header -->
use dktapps\pmforms\{MenuForm, CustomForm, CustomFormResponse, MenuOption, FormIcon};
use dktapps\pmforms\element\{Input, Slider, Dropdown, Label};
# <-- Form Footer -->

class FormManager {

	public function menuGiftCode(Player $player) : MenuForm{
	  $menu = [
	    new MenuOption("§l§a> §r§bGiftCode §l§a<"),
	    new MenuOption("§l§a> §r§5Create §bGiftCode §l§a<"),
	    new MenuOption("§l§a> §r§cRemove §bGiftCode §l§a<"),
	    new MenuOption("§l§a> §r§9List §bGiftCode §l§a<")
	    ];
	  return new MenuForm(
	    "§l§6> §aMenu §bGiftCode §6<",
	    "",
	    $menu,
	    function(Player $player, $data) : void{
	      switch($data){
	        case 0:
	          $player->sendForm($this->menuEnterCode($player));
	        break;
	        case 1:
	          $player->sendForm($this->menuCreateCode($player));
	        break;
	        case 2:
	          $player->sendForm($this->menuRemoveCode($player));
	        break;
	        case 3:
	          $all_giftcode = GiftCode::getInstance()->getCode()->getAll();
	          if($all_giftcode == null){
	             $player->sendMessage("§9[ §4ERROR §9] §cThe list of giftcodes is empty!");
	          }
	          foreach($all_giftcode as $code => $key){
                $exprire = $key["exprire"];
                $player->sendMessage("§l§aGiftcode §7".$code."§l§a with expiration time: §f".$exprire["day"]." §9day §f".$exprire["hour"]." §9hour §f".$exprire["minute"]." §9minute §f".$exprire["second"]." §9second!");
              }
	        break;
	      }
	    },
	    function(Player $player) : void{}
	    );
	}
	
	public function menuCreateCode(Player $player) : CustomForm{
	  $giftcode = GiftCode::getInstance()->getCode();
		return new CustomForm(
		  "§l§6> §aCreate §bGiftCode §6<",
		  [
		    new Input("giftcode", "GiftCode:", "Input the code in here!"),
		    new Slider("day", "Day", 0, 30),
		    new Slider("hour", "Hour", 0, 24),
		    new Slider("minute", "Minute", 0, 60),
		    new Slider("second", "Second", 0, 60),
		    new Input("command", "Command:", "Input command in here, Example: /give {player} diamond 64")
		  ],
		  function(Player $player, CustomFormResponse $data) use ($giftcode) : void{
		    $data = $data->getAll();
		    if(!isset($data["giftcode"])){
		       $player->sendMessage("§cPlease input the giftcode!");
		       return;
		    }
		    if(!isset($data["command"])){
		       $player->sendMessage("§9[ §4ERROR §9] §cPlease input command");
		       return;
		    }
		    if($giftcode->exists($data["giftcode"])){
		       $player->sendMessage("§cGiftcode §7".$data["giftcode"]." §calready. Please recreate!");
		       return;
		    }
		    GiftCode::getInstance()->createCode($data["giftcode"], (int)$data["day"], (int)$data["hour"], (int)$data["minute"], (int)$data["second"], $data["command"]);
		    $player->sendMessage("§aSuccessfully created code §7". strtolower ($data["giftcode"])." §awith time: §7".$data["day"]." §9day, §7".$data["hour"]." §9hour, §7".$data["minute"]." §9minute, §7".$data["second"]." §9second §awith command §b".$data["command"]);
		  },
		  function(Player $player) : void{
		    $player->sendMessage("§cYou're exit the create giftcode!");
		  }
		  );
	}

  public function menuRemoveCode(Player $player) : CustomForm{
    $all_giftcode = GiftCode::getInstance()->getCode()->getAll();
    return new CustomForm(
      "§l§6> §9Remove §bGiftCode §6<",
       [
         new Input("giftcode", "", "Input GiftCode To Remove")
       ],
       function(Player $player, CustomFormResponse $data) use ($all_giftcode) : void{
         $data = $data->getAll();
           if(!isset($data["giftcode"])){
              $player->sendMessage("§l§9[§4 ERROR §9] Please input giftcode to remove!");
              return;
           }
           if(!GiftCode::getInstance()->getCode()->exists($data["giftcode"])){
              $player->sendMessage("§l§9[§4 ERROR §9] §c" . $data["giftcode"] . " §cnot exists, please try again!");
              foreach($all_giftcode as $code => $key){
                $exprire = $key["exprire"];
                $player->sendMessage("§l§aGiftcode §7".$code."§l§a with expiration time: §f".$exprire["day"]." §9day §f".$exprire["hour"]." §9hour §f".$exprire["minute"]." §9minute §f".$exprire["second"]." §9second!");
              }
              return;
           }
           GiftCode::getInstance()->removeCode($data["giftcode"]);
           $player->sendMessage("§l§aSuccessfully, you removed §7" .$data["giftcode"]." §afrom the list");
       },
       function(Player $player) : void{}
       );
 }
	public function menuEnterCode(Player $player) : CustomForm{
	 $giftcode = GiftCode::getInstance()->getCode();
	 return new CustomForm(
	  "§l§6> §aEnter §bGiftCode §6<",
	  [
	    new Input("giftcode", "", "§7Please input giftcode in here!")
	  ],
	  function(Player $player, CustomFormResponse $data) use ($giftcode): void{
	    $data = $data->getAll();
	      if(!isset($data["giftcode"])){
	         $player->sendMessage("§9[ §4ERROR §9] §cPlease input giftcode in box");
	         return;
	      }
	     if(!$giftcode->exists($data["giftcode"])){
	         $player->sendMessage("§l§9[§4 ERROR §9] §cGiftcode §7".$data["giftcode"]." §cdoes not exist or has expired, please try again!");
	         return;
	      }
	      $code = $data["giftcode"];
	      $ex = explode(", ", GiftCode::getInstance()->getCode()->getNested($data["giftcode"]. ".player-used"));
	      if(!in_array($player->getDisplayName(), $ex)){
	        $im = implode(", ", $ex);
	        $playerUsed = "$im, " . $player->getDisplayName();
	        $giftcode->setNested($data["giftcode"]. ".player-used", $playerUsed);
	        $giftcode->save();
	        Server::getInstance()->getCommandMap()->dispatch(new ConsoleCommandSender(Server::getInstance(), Server::getInstance()->getLanguage()), str_replace(["{player}", "{PLAYER}"], [$player->getName()], $giftcode->get($data["giftcode"])["command"]));
	        $player->sendMessage("§9[ §eSuccessfully §9] §a You have received a gift from giftcode §7".$data["giftcode"]."§a Please check your inventory!");
	        return;
	      }else{
	        $player->sendMessage("§9[ §4ERROR §9] §cYou have already used this giftcode!");
	        return;
	      }
	  },
	  function(Player $player) : void{
	    $player->sendMessage("§l§cYou have left the place to enter the giftcode");
	  }
	 );
	}
}

<?php

declare(strict_types=1);

namespace NoobMCBG\GiftCode;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use NoobMCBG\GiftCode\command\GiftCodeCommand;
use NoobMCBG\GiftCode\task\TaskManager;

use DaPigGuy\libPiggyEconomy\libPiggyEconomy;

class GiftCode extends PluginBase implements Listener{
  
  public $editcode = [];
  public $code, $playerData;
 
 /** @var GiftCode */
	public static $instance;

	public static function getInstance() : GiftCode {
		return self::$instance;
	}
	
	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
    libPiggyEconomy::init();
		
		$this->getServer()->getCommandMap()->register("GiftCode", new GiftCodeCommand($this));
		
		$this->getScheduler()->scheduleRepeatingTask(new TaskManager($this), 20);
		self::$instance = $this;
	}

	public function onDisable() : void {
		$this->getCode()->save();
	}
	
	public function getCode() : Config{
	  if($this->code === null){
	     $this->code = new Config($this->getDataFolder() . "code.yml", Config::YAML);
   	}
  	return $this->code;
	}
	
	/**
  * @param string $name, int $time, int $hour, int $minute, int $second, string $type, int $amount
	*/
	public function createCode(string $name, int $day, int $hour, int $minute, int $second, string $type, int $amount){
	  $this->getCode()->set($name, [
	    "exprire" => ["day" => $day,
	                  "hour" => $hour,
	                  "minute" => $minute,
	                  "second" => $second
	                  ],
	    "type" => "$type",
	    "amount" => $amount,
	    "player-used" => ""
	    ]);
	  $this->getCode()->save();
	}
	
	/**
  * @param string $name
 	*/
	public function removeCode(string $name){
	  $all_code = $this->getCode()->getAll();
	  unset($all_code[$name]);
	  $this->getCode()->setAll($all_code);
	  $this->getCode()->save();
	}
}
<?php

declare(strict_types=1);



namespace NoobMCBG\GiftCode\command;



use pocketmine\Server;

use pocketmine\player\Player;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\plugin\PluginOwned;

use NoobMCBG\GiftCode\GiftCode;

use NoobMCBG\GiftCode\form\FormManager;



class GiftCodeCommand extends Command implements PluginOwned {



	private GiftCode $plugin;



	public function __construct(GiftCode $plugin){

		$this->plugin = $plugin;

		parent::__construct("giftcode", "Open GiftCode", null, ["code"]);

		$this->setPermission("giftcode.command");

	}



	public function execute(CommandSender $sender, string $label, array $args){

		if(!$sender instanceof Player){

			$sender->sendMessage("§l§cPlease use in-game");

			return true;

		}

    if(!Server::getInstance()->isOp($sender->getName()) or !$sender->hasPermission("giftcode.command.op")){

       $form = new FormManager();

       $sender->sendForm($form->menuEnterCode($sender));

    }else{

       $form = new FormManager();

       $sender->sendForm($form->menuGiftCode($sender));

    }

	}



	public function getOwningPlugin() : GiftCode {

		return $this->plugin;

	}

}


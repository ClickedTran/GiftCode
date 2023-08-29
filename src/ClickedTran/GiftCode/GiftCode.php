<?php

declare(strict_types=1);

namespace ClickedTran\GiftCode;

use DaPigGuy\libPiggyEconomy\exceptions\MissingProviderDependencyException;
use DaPigGuy\libPiggyEconomy\exceptions\UnknownProviderException;
use DaPigGuy\libPiggyEconomy\libPiggyEconomy;
use DaPigGuy\libPiggyEconomy\providers\EconomyProvider;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use CortexPE\Commando\PacketHooker;

use ClickedTran\GiftCode\command\GiftCodeCommand;
use ClickedTran\GiftCode\task\TaskManager;

class GiftCode extends PluginBase implements Listener {

	public $editcode = [];
	public $code, $playerData;

	/** @var GiftCode */
	public static $instance;

	/** @var EconomyProvider */
	private $economyProvider;

	public static function getInstance(): GiftCode {
		return self::$instance;
	}

	/**
	 * @throws MissingProviderDependencyException
	 * @throws UnknownProviderException
	 */
	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if (!PacketHooker::isRegistered()) PacketHooker::register($this);
		$this->getServer()->getCommandMap()->register("GiftCode", new GiftCodeCommand($this, "giftcode", "§o§7Giftcode Commands", ["code"]));

		$this->getScheduler()->scheduleRepeatingTask(new TaskManager($this), 20);
		self::$instance = $this;
		libPiggyEconomy::init();
		$this->economyProvider = libPiggyEconomy::getProvider($this->getConfig()->get("economy"));
	}

	public function getEconomyProvider(): EconomyProvider {
		return $this->economyProvider;
	}

	public function onDisable(): void {
		$this->getCode()->save();
	}

	public function getCode(): Config {
		if ($this->code === null) {
			$this->code = new Config($this->getDataFolder() . "code.yml", Config::YAML);
		}
		return $this->code;
	}

	/**
	 * @param string $name, int $time, int $hour, int $minute, int $second, int $amount
	 */
	public function createCode(string $name, int $day, int $hour, int $minute, int $second, int $amount) {
		$this->getCode()->set($name, [
			"exprire" => [
				"day" => $day,
				"hour" => $hour,
				"minute" => $minute,
				"second" => $second
			],
			"amount" => $amount,
			"player-used" => ""
		]);
		$this->getCode()->save();
	}

	/**
	 * @param string $name
	 */
	public function removeCode(string $name) {
		$all_code = $this->getCode()->getAll();
		unset($all_code[$name]);
		$this->getCode()->setAll($all_code);
		$this->getCode()->save();
	}
}

<?php

namespace HotshotHD;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\Player;

use pocketmine\event\entity\EntityArmorChangeEvent;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\utils\Config;
class ExoSuit extends PluginBase implements Listener {
	public $energy = array();
	
	public function onEnable() {	
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("has been enabled");
		@mkdir($this->getDataFolder());
		@mkdir($this->getDataFolder() . "Players/");
	}
	public function resetEnergy($player) {
		$this->energy[$player->getName()] = 30;
	}
	
	public function showEnergy($player) {
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new Energy($this, $player), 1);
	}
	
	public function onJoin(PlayerJoinEvent $event) {
		$player = $event->getPlayer();
		
		$this->resetEnergy($player);
		$this->showEnergy($player);
	}
	
}

?>

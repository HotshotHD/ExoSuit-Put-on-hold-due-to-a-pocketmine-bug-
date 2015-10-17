<?php

namespace HotshotHD;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\Player;

use pocketmine\event\player\PlayerItemHeldEvent;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\utils\Config;
class ExoSuit extends PluginBase implements Listener {
	public $energy = array();
	public $tasks = [];
	
	public function onEnable() {	
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("has been enabled");
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
		"Energy-Item-ID" => 280
		));
	}
	
       public function cancelTask($id) {
         unset($this->tasks[$id]);
         $this->getServer()->getScheduler()->cancelTask($id);
      }

	public function resetEnergy($player) {
           $this->energy[$player->getName()] = 30;
	}
	
	public function reduceEnergy($player) { 
	   $task = new EnergyReduce($this, $player);
           $h = $this->getServer()->getScheduler()->scheduleRepeatingTask($task, 20);
	
           $task->setHandler($h);
	   $this->tasks[$task->getTaskId()] = $task->getTaskId();
	}
	
	public function showEnergy($player) {
           $task = new Energy($this, $player);
           $h = $this->getServer()->getScheduler()->scheduleRepeatingTask($task, 20);
	
           $task->setHandler($h);
	   $this->tasks[$task->getTaskId()] = $task->getTaskId();
           $this->getServer()->getScheduler()->scheduleRepeatingTask(new Energy($this, $player), 1);
	}
	
	public function onJoin(PlayerJoinEvent $event) {
	   $player = $event->getPlayer();
		
           $this->resetEnergy($player);
	   $this->showEnergy($player);
	}
	
	public function onItemHold(PlayerItemHeldEvent $event) {
		$player = $event->getPlayer();
		
		if($event->getItem()->getId() == $this->config->get("Energy-Item-ID")) {
			$this->reduceEnergy($player);
		}
	}
	
}

?>

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
		"Energy-Item-ID" => 280,
		"Energy-Popup-Enabled" => "true"
		));
	}
	
    public function cancelTask($id) {
      unset($this->tasks[$id]);
      $this->getServer()->getScheduler()->cancelTask($id);
   }

	public function resetEnergy($player) {
		$this->setEnergy($player, 30);
	}
	
	public function setEnergy($player, $amount) {
		$this->energy = new Config($this->getDataFolder() . "Players/" . strtolower($player->getName()), Config::YAML, array(
		"Energy" => 30
		));
		
		$this->energy->set("Energy", $amount);
		$this->energy->save();
	}
	
	public function getEnergy($player) {
		$this->energy = new Config($this->getDataFolder() . "Players/" . strtolower($player->getName()), Config::YAML, array(
		"Energy" => 30
		));
		
		return $this->energy->get("Energy");
	}
	
	public function getEnergyReducetask($player) {
		return new EnergyReduce($this, $player);
	}
	public function reduceEnergy($player) {
		$energyReduce = $this->getEnergyReduceTask($player);
        $h = $this->getServer()->getScheduler()->scheduleRepeatingTask($energyReduce, 20);
	
        $energyReduce->setHandler($h);
	    $this->tasks[$this->getEnergyReduceTask($player)->getTaskId()] = $energyReduce->getTaskId();
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
		$this->energy = new Config($this->getDataFolder() . "Players/" . strtolower($player->getName()), Config::YAML, array(
		"Energy" => 30
		));
		
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

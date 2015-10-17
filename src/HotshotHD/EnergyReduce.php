<?php

namespace HotshotHD;

use pocketmine\Server;

use pocketmine\scheduler\PluginTask;

use pocketmine\Player;

class EnergyReduce extends PluginTask {

    public function __construct(ExoSuit $plugin, Player $player){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->player = $player;
    }

    public function onRun($currentTick){
			$this->plugin->setEnergy($this->player, $this->plugin->getEnergy($this->player) - 1);
			
			if($this->plugin->getEnergy($this->player) <= 0) {
			  $this->plugin->resetEnergy($this->player);
		          $this->plugin->cancelTask($this->plugin->tasks[$this->plugin->getEnergyReduceTask($this->player)->getTaskId()]);
			}
}
}

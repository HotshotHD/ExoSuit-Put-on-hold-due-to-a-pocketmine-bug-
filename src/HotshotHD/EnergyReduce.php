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
		$this->energy = $this->plugin->energy[$this->player->getName()];
    }

    public function onRun($currentTick){
        $this->energy--;

        if($this->energy == 0) {
            $this->plugin->cancelTask($this->plugin->tasks[new EnergyReduce($this->plugin, $this->player)]);
        }
    }
}

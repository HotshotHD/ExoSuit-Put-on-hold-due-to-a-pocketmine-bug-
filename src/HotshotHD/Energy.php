<?php

namespace HotshotHD;

use pocketmine\Server;

use pocketmine\scheduler\PluginTask;

use pocketmine\Player;
class Energy extends PluginTask {

    public function __construct(ExoSuit $plugin, Player $player){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->player = $player;
		}

    public function onRun($currentTick){
		if($this->plugin->config->get("Energy-Popup-Enabled") == "true") {
		   $this->player->sendPopup("Energy:" . $this->plugin->getEnergy($this->player));
		}
	}
}

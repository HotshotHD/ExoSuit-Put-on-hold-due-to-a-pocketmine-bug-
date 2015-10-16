<?php

namespace HotshotHD;

use pocketmine\Server;

use pocketmine\scheduler\PluginTask;

use pocketmine\utils\Config;
use pocketmine\item\Item;

use pocketmine\Player;
class Energy extends PluginTask {

    public function __construct(ExoSuit $plugin, Player $player){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->player = $player;
		$this->energy = $this->plugin->energy[$this->player->getName()];
    }

    public function onRun($currentTick){
			$this->player->sendPopup("Energy:" . $this->energy);
}
}
?>

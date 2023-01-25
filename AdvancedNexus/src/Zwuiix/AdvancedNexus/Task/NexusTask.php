<?php

namespace Zwuiix\AdvancedNexus\Task;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Config;
use Zwuiix\AdvancedNexus\Entities\NexusEntity;
use Zwuiix\AdvancedNexus\Handler\NexusHandler;
use Zwuiix\AdvancedNexus\Main;

class NexusTask extends Task
{
    public int $time = 30;

    public Main $plugin;

    public function __construct(Main $main, protected NexusEntity $entity, protected Config $config) {
        $this->plugin=$main;
    }

    public function onRun(): void
    {
        if(!NexusHandler::getInstance()->isNexus()){
            $this->getHandler()->cancel();
            return;
        }

        $max=0;
        $playerMax=null;
        foreach ($this->entity->getNexusCount() as $players => $value){
            if($value > $max){
                $max=$value;
                $playerMax=$players;
            }
        }
        if($playerMax == null){
            return;
        }

        $user=Server::getInstance()->getPlayerByPrefix($playerMax);
        if(!$user instanceof Player)return;
        foreach (Server::getInstance()->getOnlinePlayers() as $player){
            $player->sendPopup(str_replace(["{PLAYER}", "{MAX}"], [$player->getDisplayName(), $max], $this->config->getNested("message.winner-info")));
        }
    }
}
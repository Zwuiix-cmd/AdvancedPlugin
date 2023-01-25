<?php

namespace Zwuiix\AdvancedLightning\Listener;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use Zwuiix\AdvancedLightning\Main;
use Zwuiix\AdvancedLightning\Utils\Utils;

class EventListener implements Listener
{
    public function onDamage(EntityDamageByEntityEvent $event)
    {
        $damager=$event->getDamager();
        if(!$damager instanceof Player)return;

        $item=$damager->getInventory()->getItemInHand();
        $id=$item->getId();
        $meta=$item->getMeta();

        $config=Main::getInstance()->getData();
        foreach ($config->get("items") as $item){
            if($item["id"] !== $id || $item["meta"] !== $meta) continue;
            $chance=$item["chance"];

            $rand=mt_rand($config->getNested("chance.min"), $config->getNested("chance.max"));
            if($rand > $chance) continue;
            Utils::getInstance()->doLightning($damager);
        }
    }
}
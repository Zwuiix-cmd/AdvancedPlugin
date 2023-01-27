<?php

namespace Zwuiix\AdvancedCPS\Listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\types\LevelSoundEvent;
use Zwuiix\AdvancedCPS\Component\CPSHandler;
use Zwuiix\AdvancedCPS\Main;

class EventListener implements Listener
{
    /**
     * @param PlayerLoginEvent $event
     * @return void
     */
    public function onLogin(PlayerLoginEvent $event): void {CPSHandler::getInstance()->addPlayer($event->getPlayer());}

    /**
     * @param PlayerQuitEvent $event
     * @return void
     */
    public function onQuit(PlayerQuitEvent $event): void {CPSHandler::getInstance()->addPlayer($event->getPlayer());}

    public function onDataReceive(DataPacketReceiveEvent $event): bool
    {
        $player = ($networkSession = $event->getOrigin())->getPlayer();
        $packet = $event->getPacket();
        if($packet instanceof LevelSoundEventPacket) {
            if ($packet::NETWORK_ID === LevelSoundEventPacket::NETWORK_ID && $packet->sound === LevelSoundEvent::ATTACK_NODAMAGE or $packet->sound === LevelSoundEvent::ATTACK_STRONG) {
                if (CPSHandler::getInstance()->getCps($player) >= Main::getInstance()->getData()->get("cps-max")) {
                    $event->cancel();
                    return false;
                }
                CPSHandler::getInstance()->addClick($player);
            }
        }
        return true;
    }
}
<?php

namespace Zwuiix\AdvancedCPS\Component;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class CPSHandler
{
    use SingletonTrait;

    private array $clicks = [];
    /**
     * @param Player $player
     * @return bool
     */
    public function existPlayer(Player $player): bool
    {
        return isset($this->clicks[$player->getName()]);
    }

    /**
     * @param Player $player
     * @return void
     */
    public function addPlayer(Player $player): void
    {
        if (!$this->existPlayer($player)) {
            $this->clicks[$player->getName()] = [];
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public function removePlayer(Player $player): void
    {
        if ($this->existPlayer($player)) {
            unset($this->clicks[$player->getName()]);
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public function addClick(Player $player): void
    {
        if(!$this->existPlayer($player)){
            return;
        }
        if(is_null($this->clicks[$player->getName()])){
            return;
        }
        array_unshift($this->clicks[$player->getName()], microtime(true));
        if (count($this->clicks[$player->getName()]) > 20) {array_pop($this->clicks[$player->getName()]);}

        $player->sendTip($this->getCps($player));
    }

    /**
     * @param Player $player
     * @param float $deltaTime
     * @param int $roundPrecision
     * @return float
     */
    public function getCps(Player $player, float $deltaTime = 1.0, int $roundPrecision = 1): float
    {
        if (!$this->existPlayer($player) or empty($this->clicks[$player->getName()])) {return 0.0;}
        $mt = microtime(true);
        return round(count(array_filter($this->clicks[$player->getName()], static function (float $t) use ($deltaTime, $mt): bool {return ($mt - $t) <= $deltaTime;})) / $deltaTime, $roundPrecision);
    }

}
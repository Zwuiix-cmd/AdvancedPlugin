<?php

namespace Zwuiix\AdvancedNexus\Handler;

use pocketmine\utils\SingletonTrait;
use Zwuiix\AdvancedNexus\Entities\NexusEntity;

class NexusHandler
{
    use SingletonTrait;

    private bool $nexus = false;
    private NexusEntity $entity;

    /**
     * @return bool
     */
    public function isNexus(): bool
    {
        return $this->nexus;
    }

    /**
     * @param bool $resp
     * @return void
     */
    public function setNexus(bool $resp): void
    {
        $this->nexus=$resp;
    }

    /**
     * @return NexusEntity
     */
    public function getEntity(): NexusEntity
    {
        return $this->entity;
    }

    /**
     * @param NexusEntity $entity
     */
    public function setEntity(NexusEntity $entity): void
    {
        $this->entity = $entity;
    }
}
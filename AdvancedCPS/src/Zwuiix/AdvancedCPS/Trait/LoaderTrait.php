<?php

namespace Zwuiix\AdvancedCPS\Trait;

use Zwuiix\AdvancedCPS\Listener\EventListener;
use Zwuiix\AdvancedCPS\Main;

trait LoaderTrait
{
    use DataTrait;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->saveDefaultConfig();
        $this->initData();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }
}
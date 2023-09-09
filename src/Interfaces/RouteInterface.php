<?php

namespace UnitPhpSdk\Interfaces;

use UnitPhpSdk\Config\Listener;

interface RouteInterface
{
    /**
     * Get route name
     *
     * @return mixed
     */
    public function getName(): string;

    /**
     * Get route blocks
     *
     * @return mixed
     */
    public function getRouteBlocks(): array;
}

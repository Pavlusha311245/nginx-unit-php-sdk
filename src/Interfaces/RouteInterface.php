<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

use Pavlusha311245\UnitPhpSdk\Config\Listener;

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

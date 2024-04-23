<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Config\Listener;

interface RouteInterface extends Arrayable, Jsonable
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

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
     * Get listeners linked to route;
     *
     * @return mixed
     */
    public function getListeners(): array;

    /**
     * Setup new listener
     *
     * @param Listener $listener
     * @return void
     */
    public function setListener(Listener $listener): void;

    /**
     * Check if listeners are empty or not
     *
     * @return bool
     */
    public function hasListeners(): bool;

    /**
     * Get route blocks
     *
     * @return mixed
     */
    public function getRouteBlocks(): array;
}

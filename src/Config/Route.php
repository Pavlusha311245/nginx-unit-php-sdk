<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Config\Routes\RouteBlock;

/**
 * This class presents "routes" section from config
 */
class Route
{
    private array $_routeBlocks;

    private array $_listeners = [];

    public function __construct(
        private readonly string $_name,
        $data)
    {
        foreach ($data as $routeBlock) {
            $this->_routeBlocks[] = new RouteBlock($routeBlock);
        }
    }

    /**
     * Return Listener
     *
     * @param  mixed  $listener
     */
    public function setListener(Listener $listener): void
    {
        $this->_listeners[$listener->getListener()] = $listener;
    }

    public function getListeners(): array
    {
        return $this->_listeners;
    }

    /**
     * Get name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Return RouteBlock (action, match)
     *
     * @return array
     */
    public function getRouteBlocks(): array
    {
        return $this->_routeBlocks;
    }
}

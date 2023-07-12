<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Config\Routes\RouteBlock;

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
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    public function getRouteBlocks(): array
    {
        return $this->_routeBlocks;
    }
}

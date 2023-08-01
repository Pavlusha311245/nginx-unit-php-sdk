<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Config\Routes\RouteBlock;
use Pavlusha311245\UnitPhpSdk\Interfaces\RouteInterface;

/**
 * This class presents "routes" section from config
 */
class Route implements RouteInterface
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
     * @inheritDoc
     */
    public function hasListeners(): bool
    {
        return !empty($this->_listeners);
    }

    /**
     * @inheritDoc
     */
    public function setListener(Listener $listener): void
    {
        $this->_listeners[$listener->getListener()] = $listener;
    }

    /**
     * @inheritDoc
     */
    public function getListeners(): array
    {
        return $this->_listeners;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @inheritDoc
     */
    public function getRouteBlocks(): array
    {
        return $this->_routeBlocks;
    }
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Config\Routes\RouteBlock;
use Pavlusha311245\UnitPhpSdk\Interfaces\RouteInterface;
use Pavlusha311245\UnitPhpSdk\Traits\HasListeners;

/**
 * This class presents "routes" section from config
 */
class Route implements RouteInterface
{
    use HasListeners;

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

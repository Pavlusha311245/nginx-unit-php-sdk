<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Config\Routes\RouteBlock;
use UnitPhpSdk\Interfaces\RouteInterface;
use UnitPhpSdk\Traits\HasListeners;

/**
 * This class presents "routes" section from config
 */
class Route implements RouteInterface
{
    use HasListeners;

    /**
     * @var array
     */
    private array $_routeBlocks;

    /**
     * @var array
     */
    private array $_listeners = [];

    public function __construct(
        private readonly string $_name,
        $data,
        bool                    $single = false
    ) {
        if ($single) {
            $this->_routeBlocks[] = new RouteBlock($data);
        } else {
            foreach ($data as $routeBlock) {
                $this->_routeBlocks[] = new RouteBlock($routeBlock);
            }
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

<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Config\Routes\RouteBlock;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\RouteInterface;
use UnitPhpSdk\Traits\HasListeners;

/**
 * This class presents "routes" section from config
 *
 * @implements RouteInterface
 */
class Route implements RouteInterface, Arrayable
{
    use HasListeners;

    /**
     * @var array
     */
    private array $routeBlocks = [];

    /**
     * @var array
     */
    private array $listeners = [];

    public function __construct(
        private readonly string $name,
        $data = [],
        bool                    $single = false
    ) {
        if (!empty($data)) {
            if ($single) {
                $this->routeBlocks[] = new RouteBlock($data);
            } else {
                foreach ($data as $routeBlock) {
                    $this->routeBlocks[] = new RouteBlock($routeBlock);
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $routeBlocks
     */
    public function setRouteBlocks(array $routeBlocks): void
    {
        $this->routeBlocks = $routeBlocks;
    }

    /**
     * @inheritDoc
     */
    public function getRouteBlocks(): array
    {
        return $this->routeBlocks;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getRouteBlocks();
    }

    /**
     * @return string|false
     */
    public function toJson(): string|false
    {
        return json_encode(array_filter($this->toArray(), fn ($item) => !empty($item)));
    }
}

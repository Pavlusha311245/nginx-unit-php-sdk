<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Config\Routes\RouteBlock;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Jsonable;
use UnitPhpSdk\Contracts\RouteInterface;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Traits\HasListeners;

/**
 * This class presents "routes" section from config
 *
 * @implements RouteInterface
 */
class Route implements RouteInterface, Arrayable, Jsonable
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

    /**
     * @throws UnitException
     */
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
    #[\Override] public function toArray(): array
    {
        return array_map(fn (RouteBlock $routeBlock) => $routeBlock->toArray(), $this->routeBlocks);
    }

    /**
     * @param int $options
     * @return string
     */
    #[\Override] public function toJson(int $options = 0): string
    {
        return json_encode(array_filter($this->toArray(), fn ($item) => !empty($item)));
    }
}

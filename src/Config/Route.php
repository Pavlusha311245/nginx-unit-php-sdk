<?php

namespace UnitPhpSdk\Config;

use Override;
use SplObjectStorage;
use UnitPhpSdk\Builders\EndpointBuilder;
use UnitPhpSdk\Config\Routes\RouteBlock;
use UnitPhpSdk\Contracts\RouteInterface;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Enums\ApiPathEnum;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Traits\CanUpload;
use UnitPhpSdk\Traits\HasListeners;

/**
 * This class presents "routes" section from config
 *
 * @implements RouteInterface
 */
class Route implements RouteInterface, Uploadable
{
    use HasListeners;
    use CanUpload;

    /**
     * @var SplObjectStorage|null
     */
    private ?SplObjectStorage $routeBlocks = null;

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
    )
    {
        $this->routeBlocks = new SplObjectStorage();
        if (!empty($data)) {
            if ($single) {
                $this->routeBlocks->attach(new RouteBlock($data));
            } else {
                foreach ($data as $routeBlock) {
                    $this->routeBlocks->attach(new RouteBlock($routeBlock));
                }
            }
        }

        $this->setApiEndpoint(ApiPathEnum::ROUTE->getPath($this->getName()));
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
     * @throws UnitException
     */
    public function setRouteBlocks(array $routeBlocks): void
    {
        foreach ($routeBlocks as $routeBlock) {
            $this->routeBlocks->attach(
                $routeBlock instanceof RouteBlock ? $routeBlock : new RouteBlock($routeBlock)
            );
        }
    }

    public function getRouteBlock($index): RouteBlock
    {
        return $this->routeBlocks->offsetGet($index);
    }

    public function removeRouteBlock($index): void
    {
        $this->routeBlocks->offsetUnset($index);
    }

    /**
     * @param RouteBlock $routeBlock
     * @return void
     */
    public function addRouteBlock(RouteBlock $routeBlock): void
    {
        $this->routeBlocks->attach($routeBlock);
    }

    /**
     * @inheritDoc
     */
    public function getRouteBlocks(): array
    {
        $data = [];

        foreach ($this->routeBlocks as $routeBlock) {
            $data[] = $routeBlock;
        }

        return $data;
    }

    /**
     * @return array
     */
    #[Override] public function toArray(): array
    {
        return array_map(fn(RouteBlock $routeBlock) => $routeBlock->toArray(), $this->getRouteBlocks());
    }

    /**
     * @param int $options
     * @return string
     */
    #[Override] public function toJson(int $options = 0): string
    {
        return json_encode(array_filter($this->toArray(), fn($item) => !empty($item)));
    }
}

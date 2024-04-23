<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Config\Routes\RouteBlock;
use UnitPhpSdk\Contracts\RouteInterface;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Traits\HasListeners;

/**
 * This class presents "routes" section from config
 *
 * @implements RouteInterface
 */
class Route implements RouteInterface, Uploadable
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
    )
    {
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
        return array_map(fn(RouteBlock $routeBlock) => $routeBlock->toArray(), $this->routeBlocks);
    }

    /**
     * @param int $options
     * @return string
     */
    #[\Override] public function toJson(int $options = 0): string
    {
        return json_encode(array_filter($this->toArray(), fn($item) => !empty($item)));
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function upload(UnitRequest $request)
    {
        $request->setMethod(HttpMethodsEnum::PUT->value)->send(
            $this->getApiEndpoint(),
            true,
            ['json' => array_filter($this->toArray(), fn($item) => !empty($item))]
        );
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function remove(UnitRequest $request)
    {
        $request->setMethod(HttpMethodsEnum::DELETE->value)->send($this->getApiEndpoint());
    }

    private function getApiEndpoint()
    {
        return '/config/routes/' . $this->getName();
    }
}

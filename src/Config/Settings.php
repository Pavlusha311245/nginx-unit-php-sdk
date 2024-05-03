<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Builders\EndpointBuilder;
use UnitPhpSdk\Config\Settings\Http;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Jsonable;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Traits\CanUpload;

class Settings implements Uploadable, Arrayable, Jsonable
{
    use CanUpload;

    /**
     * Fine-tunes handling of HTTP requests from the clients
     *
     * @var Http|null
     */
    private ?Http $http = null;

    /**
     * @var string|array
     */
    private string|array $js_module = [];

    public function __construct(array $data = [])
    {
        if (array_key_exists('http', $data)) {
            $this->parseHttp($data['http']);
        }

        if (array_key_exists('js_module', $data)) {
            $this->parseJsModule($data['js_module']);
        }

        $this->setApiEndpoint(EndpointBuilder::create($this)->get());
    }

    /**
     * @return Http|null
     */
    public function getHttp(): ?Http
    {
        return $this->http;
    }

    private function parseHttp(array $data): void
    {
        $this->http = new Http($data);
    }

    private function parseJsModule(array|string $data): void
    {
        $this->js_module = $data;
    }

    /**
     * @return array|string
     */
    public function getJsModule(): array|string
    {
        return $this->js_module;
    }

    /**
     * @param array|string $js_module
     */
    public function setJsModule(array|string $js_module): void
    {
        $this->js_module = $js_module;
    }

    #[\Override] public function toArray(): array
    {
        return [
            'http' => $this->getHttp()?->toArray(),
            'js_module' => $this->getJsModule()
        ];
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function toJson(int $options = 0): string
    {
        return json_encode(array_filter($this->toArray(), fn ($item) => !empty($item)), $options);
    }
}

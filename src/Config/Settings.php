<?php

namespace UnitPhpSdk\Config;

use InvalidArgumentException;
use UnitPhpSdk\Builders\EndpointBuilder;
use UnitPhpSdk\Config\Settings\Http;
use UnitPhpSdk\Config\Settings\Telemetry;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Jsonable;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Traits\CanUpload;

class Settings implements Uploadable, Arrayable, Jsonable
{
    use CanUpload;

    private const array REQUIRED_TELEMETRY_KEYS = ['endpoint', 'protocol'];

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

    /**
     * @var Telemetry|mixed|null
     */
    private ?Telemetry $telemetry = null;

    public function __construct(array $data = [])
    {
        if (array_key_exists('http', $data)) {
            $this->parseHttp($data['http']);
        }

        if (array_key_exists('js_module', $data)) {
            $this->parseJsModule($data['js_module']);
        }

        if (array_key_exists('telemetry', $data)) {
            $this->parseTelemetry($data['telemetry']);
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

    private function parseTelemetry(array $data): void
    {
        $this->validateTelemetryData($data);

        $this->telemetry = new Telemetry(
            endpoint: $data['endpoint'],
            protocol: $data['protocol']
        );

        if (array_key_exists('sampling_ratio', $data)) {
            $this->telemetry->setSamplingRatio($data['sampling_ratio']);
        }

        if (array_key_exists('batch_size', $data)) {
            $this->telemetry->setBatchSize($data['batch_size']);
        }
    }

    private function validateTelemetryData(array $data): void
    {
        foreach (self::REQUIRED_TELEMETRY_KEYS as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException("Telemetry {$key} is required");
            }
        }
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
        return json_encode(array_filter($this->toArray(), fn($item) => !empty($item)), $options);
    }
}

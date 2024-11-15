<?php

namespace UnitPhpSdk\Config\Settings;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Jsonable;
use UnitPhpSdk\Enums\TelemetryProtocolEnum;

class Telemetry implements Arrayable, Jsonable
{
    /**
     * Number of spans to cache before triggering a transaction with the configured endpoint. This is optional.
     *
     * @var int|null $batch_size
     */
    private ?int $batch_size = 50;

    /**
     * Percentage of requests to trace. This is optional.
     *
     * @var float|null $sampling_ratio
     */
    private ?float $sampling_ratio = 1.0;

    public function __construct(
        /**
         * The endpoint for the OpenTelemetry (OTEL) Collector. This is required.
         *
         * @var string $endpoint
         */
        private string                $endpoint,
        /**
         * Determines the protocol used to communicate with the endpoint. This is required.
         *
         * @var TelemetryProtocolEnum $protocol
         */
        private TelemetryProtocolEnum $protocol
    )
    {
        $this->setEndpoint($endpoint);
        $this->setProtocol($protocol);
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    public function getProtocol(): TelemetryProtocolEnum
    {
        return $this->protocol;
    }

    public function setProtocol(TelemetryProtocolEnum $protocol): void
    {
        $this->protocol = $protocol;
    }

    public function getBatchSize(): ?int
    {
        return $this->batch_size;
    }

    public function setBatchSize(?int $batch_size): void
    {
        $this->batch_size = $batch_size;
    }

    public function getSamplingRatio(): ?float
    {
        return $this->sampling_ratio;
    }

    public function setSamplingRatio(?float $sampling_ratio): void
    {
        $this->sampling_ratio = $sampling_ratio;
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function toArray(): array
    {
        return [
            'endpoint' => $this->getEndpoint(),
            'protocol' => $this->getProtocol(),
            'batch_size' => $this->getBatchSize(),
            'sampling_ratio' => $this->getSamplingRatio()
        ];
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
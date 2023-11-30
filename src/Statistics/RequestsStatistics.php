<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\RequestsStatisticsInterface;

/**
 * @readonly RequestsStatistics
 * @implements RequestsStatisticsInterface, Arrayable
 * @final
 */
final readonly class RequestsStatistics implements RequestsStatisticsInterface, Arrayable
{
    public function __construct(private array $data)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function getTotalRequests(): int
    {
        return $this->data['total'];
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->data;
    }
}

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
    public function __construct(private array $_data)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function getTotalRequests(): int
    {
        return $this->_data['total'];
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->_data;
    }
}

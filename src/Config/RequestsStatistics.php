<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Contracts\RequestsStatisticsInterface;

readonly class RequestsStatistics implements RequestsStatisticsInterface
{
    public function __construct(private array $_data)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->_data;
    }

    /**
     * @inheritDoc
     */
    public function getTotalRequests(): int
    {
        return $this->_data['total'];
    }
}

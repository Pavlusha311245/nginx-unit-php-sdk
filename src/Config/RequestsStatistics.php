<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Interfaces\RequestsStatisticsInterface;

class RequestsStatistics implements RequestsStatisticsInterface
{
    public function __construct(private array $_data)
    {
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
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

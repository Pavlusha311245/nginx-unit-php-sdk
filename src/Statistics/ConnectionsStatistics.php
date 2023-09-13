<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\ConnectionsStatisticsInterface;

/**
 * @readonly ConnectionsStatistics
 * @implements ConnectionsStatisticsInterface, Arrayable
 * @final
 */
final readonly class ConnectionsStatistics implements ConnectionsStatisticsInterface, Arrayable
{
    public function __construct(private array $_data)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function getIdleConnections(): int
    {
        return $this->_data['idle'];
    }

    /**
     * @inheritDoc
     */
    public function getActiveConnections(): int
    {
        return $this->_data['active'];
    }

    /**
     * @inheritDoc
     */
    public function getAcceptedConnections(): int
    {
        return $this->_data['accepted'];
    }

    /**
     * @inheritDoc
     */
    public function getClosedConnections(): int
    {
        return $this->_data['closed'];
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->_data;
    }
}

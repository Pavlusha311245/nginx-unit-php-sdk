<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Interfaces\ConnectionsStatisticsInterface;

readonly class ConnectionsStatistics implements ConnectionsStatisticsInterface
{
    public function __construct(private array $_data)
    {
        //
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
}

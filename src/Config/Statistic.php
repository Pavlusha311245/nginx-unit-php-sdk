<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Interfaces\StatisticsInterface;

class Statistic implements StatisticsInterface
{
    private array $_connections;

    private array $_requests;

    private array $_applications;

    public function __construct(array $data)
    {
        $this->_connections = $data['connections'];
        $this->_requests = $data['requests'];
        $this->_applications = $data['applications'];
    }

    public function getConnections(): array
    {
        return $this->_connections;
    }

    public function getRequests(): array
    {
        return $this->_requests;
    }

    public function getApplications(): array
    {
        return $this->_applications;
    }
}

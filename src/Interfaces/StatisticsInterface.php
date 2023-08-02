<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Config\ConnectionsStatistics;
use Pavlusha311245\UnitPhpSdk\Config\RequestsStatistics;

interface StatisticsInterface
{
    /**
     * Get connections
     *
     * @return ConnectionsStatisticsInterface
     */
    public function getConnections(): ConnectionsStatisticsInterface;

    /**
     * Get requests
     *
     * @return RequestsStatisticsInterface
     */
    public function getRequests(): RequestsStatisticsInterface;

    /**
     * Get an applications
     *
     * @return array
     */
    public function getApplications(): array;

    /**
     * Get application statistics
     *
     * @param ApplicationAbstract|string $application
     * @return ApplicationsStatisticsInterface
     */
    public function getApplicationStatistics(ApplicationAbstract|string $application): ApplicationsStatisticsInterface;
}

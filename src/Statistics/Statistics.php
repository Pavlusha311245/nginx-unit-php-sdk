<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Abstract\ApplicationAbstract;
use UnitPhpSdk\Contracts\{ApplicationStatisticsInterface,
    ConnectionsStatisticsInterface,
    RequestsStatisticsInterface,
    StatisticsInterface};

/**
 * This class returns statistics from Nginx Unit
 *
 * @implements StatisticsInterface
 * @final
 */
final class Statistics implements StatisticsInterface
{
    /**
     * @var ConnectionsStatisticsInterface
     */
    private ConnectionsStatisticsInterface $_connections;

    /**
     * @var RequestsStatisticsInterface
     */
    private RequestsStatisticsInterface $_requests;

    /**
     * @var array|ApplicationStatistics[]
     */
    private array $_applications;

    public function __construct(array $data)
    {
        $this->_connections = new ConnectionsStatistics($data['connections']);
        $this->_requests = new RequestsStatistics($data['requests']);
        $this->_applications = array_map(fn ($item) => new ApplicationStatistics($item), $data['applications']);
    }

    /**
     * @inheritDoc
     */
    public function getConnections(): ConnectionsStatisticsInterface
    {
        return $this->_connections;
    }

    /**
     * @inheritDoc
     */
    public function getRequests(): RequestsStatisticsInterface
    {
        return $this->_requests;
    }

    /**
     * @inheritDoc
     */
    public function getApplications(): array
    {
        return $this->_applications;
    }

    /**
     * @inheritDoc
     */
    public function getApplicationStatistics(ApplicationAbstract|string $application): ApplicationStatisticsInterface
    {
        if (is_string($application)) {
            return $this->_applications[$application];
        }

        return $this->_applications[$application->getName()];
    }
}

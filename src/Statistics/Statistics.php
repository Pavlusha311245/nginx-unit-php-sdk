<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Abstract\AbstractApplication;
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
    private ConnectionsStatisticsInterface $connections;

    /**
     * @var RequestsStatisticsInterface
     */
    private RequestsStatisticsInterface $requests;

    /**
     * @var array|ApplicationStatistics[]
     */
    private array $applications;

    public function __construct(array $data)
    {
        $this->connections = new ConnectionsStatistics($data['connections']);
        $this->requests = new RequestsStatistics($data['requests']);
        $this->applications = array_map(fn ($item) => new ApplicationStatistics($item), $data['applications']);
    }

    /**
     * @inheritDoc
     */
    public function getConnections(): ConnectionsStatisticsInterface
    {
        return $this->connections;
    }

    /**
     * @inheritDoc
     */
    public function getRequests(): RequestsStatisticsInterface
    {
        return $this->requests;
    }

    /**
     * @inheritDoc
     */
    public function getApplications(): array
    {
        return $this->applications;
    }

    /**
     * @inheritDoc
     */
    public function getApplicationStatistics(AbstractApplication|string $application): ApplicationStatisticsInterface
    {
        if (is_string($application)) {
            return $this->applications[$application];
        }

        return $this->applications[$application->getName()];
    }
}

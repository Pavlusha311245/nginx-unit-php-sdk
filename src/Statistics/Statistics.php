<?php

namespace UnitPhpSdk\Statistics;

use Exception;
use InvalidArgumentException;
use Override;
use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Contracts\{ApplicationStatisticsInterface,
    Arrayable,
    ConnectionsStatisticsInterface,
    RequestsStatisticsInterface,
    StatisticsInterface
};
use UnitPhpSdk\Exceptions\UnitParseException;

/**
 * This class returns statistics from Nginx Unit
 *
 * @implements StatisticsInterface
 * @final
 */
final readonly class Statistics implements StatisticsInterface
{
    /**
     * Connections statistics
     *
     * @var ConnectionsStatisticsInterface
     */
    private ConnectionsStatisticsInterface $connections;

    /**
     * Requests statistics
     *
     * @var RequestsStatisticsInterface
     */
    private RequestsStatisticsInterface $requests;

    /**
     * Applications statistics
     *
     * @var array|ApplicationStatistics[]
     */
    private array $applications;

    /**
     * @throws UnitParseException
     */
    public function __construct(array $data)
    {
        //        $this->unitInformation = new UnitStatistics($data['unit']);
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
            if (!array_key_exists($application, $this->applications)) {
                throw new InvalidArgumentException('Application with name ' . $application . ' not found');
            }

            return $this->applications[$application];
        }

        return $this->applications[$application->getName()];
    }

    /**
     * @inheritDoc
     */
    #[Override] public function toArray(): array
    {
        return [
            'connections' => $this->connections->toArray(),
            'requests' => $this->requests->toArray(),
            'applications' => array_map(fn ($item) => $item->toArray(), $this->applications),
        ];
    }

    /**
     * @inheritDoc
     */
    #[Override] public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}

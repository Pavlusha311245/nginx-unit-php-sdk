<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Abstract\AbstractApplication;

interface StatisticsInterface extends Arrayable, Jsonable
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
     * @param AbstractApplication|string $application
     * @return ApplicationStatisticsInterface
     */
    public function getApplicationStatistics(AbstractApplication|string $application): ApplicationStatisticsInterface;

    /**
     * @inheritDoc
     */
    public function toArray(): array;

    /**
     * @inheritDoc
     */
    public function toJson(int $options = 0): string;
}

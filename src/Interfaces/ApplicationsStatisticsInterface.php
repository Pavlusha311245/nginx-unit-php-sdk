<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface ApplicationsStatisticsInterface
{
    /**
     * Return all application statistics
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Get count of all application requests
     *
     * @return int
     */
    public function getRequests(): int;

    /**
     * Get count of starting application processes
     *
     * @return int
     */
    public function getStartingProcesses(): int;

    /**
     * Get count of running application processes
     *
     * @return int
     */
    public function getRunningProcesses(): int;

    /**
     * Get count of idle application processes
     *
     * @return int
     */
    public function getIdleProcesses(): int;
}

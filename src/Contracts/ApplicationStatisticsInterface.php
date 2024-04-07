<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Statistics\Processes;

interface ApplicationStatisticsInterface
{
    /**
     * Get array of all application requests
     *
     * @return array
     */
    public function getRequests(): array;

    /**
     * Get count of all application active requests
     *
     * @return int
     */
    public function getActiveRequests(): int;

    /**
     * Return all statistics by processes
     *
     * @return Processes
     */
    public function getProcesses(): Processes;

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

<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface ApplicationsStatisticsInterface
{
    /**
     * Return all application statistics
     *
     * @return array
     */
    public function getData(): array;

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
     * @return array
     */
    public function getProcesses(): array;

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

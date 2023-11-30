<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Contracts\ApplicationStatisticsInterface;
use UnitPhpSdk\Contracts\Arrayable;

/**
 * @readonly ApplicationStatistics
 * @implements ApplicationStatisticsInterface
 * @final
 */
final readonly class ApplicationStatistics implements ApplicationStatisticsInterface, Arrayable
{
    public function __construct(private array $data)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function getRequests(): array
    {
        return $this->data['requests'];
    }

    /**
     * @inheritDoc
     */
    public function getActiveRequests(): int
    {
        return $this->data['requests']['active'];
    }

    /**
     * @inheritDoc
     */
    public function getProcesses(): array
    {
        return $this->data['processes'];
    }

    /**
     * @inheritDoc
     */
    public function getStartingProcesses(): int
    {
        return $this->data['processes']['starting'];
    }

    /**
     * @inheritDoc
     */
    public function getRunningProcesses(): int
    {
        return $this->data['processes']['running'];
    }

    /**
     * @inheritDoc
     */
    public function getIdleProcesses(): int
    {
        return $this->data['processes']['idle'];
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->data;
    }
}

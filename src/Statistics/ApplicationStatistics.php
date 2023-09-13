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
    public function __construct(private array $_data)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function getRequests(): array
    {
        return $this->_data['requests'];
    }

    /**
     * @inheritDoc
     */
    public function getActiveRequests(): int
    {
        return $this->_data['requests']['active'];
    }

    /**
     * @inheritDoc
     */
    public function getProcesses(): array
    {
        return $this->_data['processes'];
    }

    /**
     * @inheritDoc
     */
    public function getStartingProcesses(): int
    {
        return $this->_data['processes']['starting'];
    }

    /**
     * @inheritDoc
     */
    public function getRunningProcesses(): int
    {
        return $this->_data['processes']['running'];
    }

    /**
     * @inheritDoc
     */
    public function getIdleProcesses(): int
    {
        return $this->_data['processes']['idle'];
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->_data;
    }
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Interfaces\ApplicationsStatisticsInterface;

readonly class ApplicationsStatistics implements ApplicationsStatisticsInterface
{
    public function __construct(private array $_data)
    {
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->_data;
    }

    /**
     * @inheritDoc
     */
    public function getRequests(): int
    {
        return $this->_data['requests']['active'];
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
}

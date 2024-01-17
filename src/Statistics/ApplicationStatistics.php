<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Contracts\{ApplicationStatisticsInterface, Arrayable};
use UnitPhpSdk\Exceptions\UnitParseException;

/**
 * @readonly ApplicationStatistics
 * @implements ApplicationStatisticsInterface
 * @final
 */
final readonly class ApplicationStatistics implements ApplicationStatisticsInterface, Arrayable
{
    /**
     * Active requests
     *
     * @var array|mixed
     */
    private int $activeRequests;

    /**
     * Processes
     *
     * @var array|mixed
     */
    private array $processes;

    /**
     * @throws UnitParseException
     */
    public function __construct(array $data)
    {
        $this->parseFromArray($data);
    }

    /**
     * @param array $data
     * @return void
     * @throws UnitParseException
     */
    private function parseFromArray(array $data): void
    {
        if (!array_key_exists('processes', $data)
            || !array_key_exists('requests', $data)
            || !array_key_exists('active', $data['requests'])
            || !array_key_exists('running', $data['processes'])
            || !array_key_exists('starting', $data['processes'])
            || !array_key_exists('idle', $data['processes'])
        ) {
            throw new UnitParseException('One or more keys are don\'t exists');
        }

        $this->activeRequests = $data['requests']['active'];
        $this->processes = $data['processes'];
    }

    /**
     * @inheritDoc
     */
    public function getRequests(): array
    {
        return [
            'active' => $this->activeRequests
        ];
    }

    /**
     * @inheritDoc
     */
    public function getActiveRequests(): int
    {
        return $this->activeRequests;
    }

    /**
     * @inheritDoc
     */
    public function getProcesses(): array
    {
        return $this->processes;
    }

    /**
     * @inheritDoc
     */
    public function getStartingProcesses(): int
    {
        return $this->processes['starting'];
    }

    /**
     * @inheritDoc
     */
    public function getRunningProcesses(): int
    {
        return $this->processes['running'];
    }

    /**
     * @inheritDoc
     */
    public function getIdleProcesses(): int
    {
        return $this->processes['idle'];
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'processes' => [
                'running' => $this->getRunningProcesses(),
                'starting' => $this->getStartingProcesses(),
                'idle' => $this->getIdleProcesses()
            ],
            'requests' => [
                'active' => $this->getActiveRequests()
            ]
        ];
    }
}

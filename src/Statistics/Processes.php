<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Exceptions\UnitParseException;

final readonly class Processes implements Arrayable
{
    /**
     * Running processes
     *
     * @var int
     */
    private int $running;

    /**
     * Starting processes
     *
     * @var int
     */
    private int $starting;

    /**
     * Idle processes
     *
     * @var int
     */
    private int $idle;

    /**
     * @throws UnitParseException
     */
    public function __construct(array $data)
    {
        $this->parseFromArray($data);
    }

    private function parseFromArray(array $data): void
    {
        if (!array_key_exists('running', $data)
            || !array_key_exists('starting', $data)
            || !array_key_exists('idle', $data)) {
            throw new UnitParseException('One or more keys are don\'t exists');
        }

        $this->running = $data['running'];
        $this->starting = $data['starting'];
        $this->idle = $data['idle'];
    }

    /**
     * @return int
     */
    public function getRunning(): int
    {
        return $this->running;
    }

    /**
     * @return int
     */
    public function getStarting(): int
    {
        return $this->starting;
    }

    /**
     * @return int
     */
    public function getIdle(): int
    {
        return $this->idle;
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function toArray(): array
    {
        return [
            'running' => $this->running,
            'starting' => $this->starting,
            'idle' => $this->idle
        ];
    }
}

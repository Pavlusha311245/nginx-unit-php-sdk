<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement;

use UnitPhpSdk\Contracts\Arrayable;

/**
 * @implements Arrayable
 */
class ApplicationProcess implements Arrayable
{
    /**
     * Maximum number of application processes that Unit maintains (busy and idle).
     *
     * @var int|mixed
     */
    private int $max = 1;

    /**
     * Minimum number of idle processes that Unit tries to maintain for an app.
     *
     * @var int|mixed
     */
    private int|null $spare = null;

    /**
     * Number of seconds Unit waits for before terminating an idle process that exceeds spare.
     *
     * @var int|mixed
     */
    private int|null $idle_timeout = null;

    public function __construct(array $data = [])
    {
        if (array_key_exists('max', $data)) {
            $this->setMax($data['max']);
        }

        if (array_key_exists('spare', $data)) {
            $this->setSpare($data['spare']);
        }

        if (array_key_exists('idle_timeout', $data)) {
            $this->setIdleTimeout($data['idle_timeout']);
        }
    }

    /**
     * @return array
     */
    #[\Override] public function toArray(): array
    {
        $result = [];

        if (!empty($this->getMax())) {
            $result['max'] = $this->getMax();
        }

        if (!empty($this->getSpare())) {
            $result['spare'] = $this->getSpare();
        }

        if (!empty($this->getIdleTimeout())) {
            $result['idle_timeout'] = $this->getIdleTimeout();
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @param int $max
     * @return ApplicationProcess
     */
    public function setMax(int $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSpare(): int|null
    {
        return $this->spare;
    }

    /**
     * @param int $spare
     * @return ApplicationProcess
     */
    public function setSpare(int $spare): self
    {
        $this->spare = $spare;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdleTimeout(): int|null
    {
        return $this->idle_timeout;
    }

    /**
     * @param int $idle_timeout
     * @return ApplicationProcess
     */
    public function setIdleTimeout(int $idle_timeout): self
    {
        $this->idle_timeout = $idle_timeout;

        return $this;
    }
}

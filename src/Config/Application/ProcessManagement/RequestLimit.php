<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement;

use UnitPhpSdk\Contracts\Arrayable;

/**
 * @implements Arrayable
 */
class RequestLimit implements Arrayable
{
    /**
     * Maximum number of requests an app process can serve.
     *
     * @var int
     */
    private int $requests;

    /**
     * Request timeout in seconds.
     *
     * @var int
     */
    private int $timeout;

    public function __construct(array $data = [])
    {
        if (array_key_exists('timeout', $data)) {
            $this->setTimeout($data['timeout']);
        }

        if (array_key_exists('requests', $data)) {
            $this->setRequests($data['requests']);
        }
    }

    public function toArray(): array
    {
        return [
            'timeout' => $this->getTimeout(),
            'requests' => $this->getRequests()
        ];
    }

    /**
     * @return int
     */
    public function getRequests(): int
    {
        return $this->requests;
    }

    /**
     * @param int $requests
     */
    public function setRequests(int $requests): void
    {
        $this->requests = $requests;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement;

use Pavlusha311245\UnitPhpSdk\Interfaces\Arrayable;

class RequestLimit implements Arrayable
{
    /**
     * Maximum number of requests an app process can serve.
     *
     * @var int
     */
    private int $_requests;

    /**
     * Request timeout in seconds.
     *
     * @var int
     */
    private int $_timeout;

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
        return $this->_requests;
    }

    /**
     * @param int $requests
     */
    public function setRequests(int $requests): void
    {
        $this->_requests = $requests;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->_timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->_timeout = $timeout;
    }
}

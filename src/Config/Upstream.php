<?php

namespace UnitPhpSdk\Config;

use OutOfRangeException;
use UnitPhpSdk\Contracts\UpstreamInterface;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Traits\HasListeners;

/**
 * @implements UpstreamInterface
 */
class Upstream implements UpstreamInterface
{
    use HasListeners;

    /**
     * Array of servers
     *
     * @var array
     */
    private array $servers = [];

    public function __construct(
        private readonly string $name,
        array                   $data = []
    ) {
        if (!empty($data)) {
            if (array_key_exists('servers', $data)) {
                $this->setServers($data['servers']);
            }
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $servers
     */
    private function setServers(array $servers): void
    {
        $this->servers = $servers;
    }

    /**
     * @param string $ip
     * @param int $weight
     * @return void
     * @throws UnitException
     */
    public function setServer(string $ip, int $weight = 1): void
    {
        if ($weight < 0 || $weight > 1000000) {
            throw new OutOfRangeException('Weight should be between 0 and 1000000');
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new UnitException("$ip isn't a valid IP address");
        }

        $this->servers[$ip] = [
            'weight' => $weight
        ];
    }

    /**
     * @return array
     */
    public function getServers(): array
    {
        return $this->servers;
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        return [
            'servers' => $this->getServers()
        ];
    }

    /**
     * @return string|false
     */
    public function toJson(): string|false
    {
        return json_encode($this->toArray());
    }
}

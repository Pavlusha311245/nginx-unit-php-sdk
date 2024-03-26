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
    public function setServer(string $pass, int $weight = 1): void
    {
        if ($weight < 0 || $weight > 1000000) {
            throw new OutOfRangeException('Weight should be between 0 and 1000000');
        }

        $parts = parse_url($pass);

        if (!filter_var($parts['host'], FILTER_VALIDATE_IP)) {
            throw new UnitException($parts['host'] . " isn't a valid IP address");
        }

        if ((int)$parts['port'] < 1 || (int)$parts['port'] > 65535) {
            throw new UnitException($parts['port'] . " isn't a valid port number (allowed range is 1 to 65535)");
        }

        $this->servers[$parts['host']] = [
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

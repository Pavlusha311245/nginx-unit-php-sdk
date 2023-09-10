<?php

namespace UnitPhpSdk\Config;

use OutOfRangeException;
use UnitPhpSdk\Contracts\UpstreamInterface;
use UnitPhpSdk\Traits\HasListeners;

class Upstream implements UpstreamInterface
{
    use HasListeners;

    private array $_servers = [];

    public function __construct(
        private readonly string $_name,
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
        return $this->_name;
    }

    /**
     * @param array $servers
     */
    private function setServers(array $servers): void
    {
        $this->_servers = $servers;
    }

    /**
     * @param string $ip
     * @param int $weight
     * @return void
     */
    public function setServer(string $ip, int $weight = 1): void
    {
        if ($weight < 0 || $weight > 1000000) {
            throw new OutOfRangeException('Weight should be between 0 and 1000000');
        }

        $this->_servers[$ip] = [
            'weight' => $weight
        ];
    }

    /**
     * @return array
     */
    public function getServers(): array
    {
        return $this->_servers;
    }

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

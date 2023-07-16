<?php

namespace Pavlusha311245\UnitPhpSdk;

use Pavlusha311245\UnitPhpSdk\Config\Statistic;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;
use Pavlusha311245\UnitPhpSdk\Interfaces\UnitInterface;

/**
 * This is main class of Nginx Unit manipulation
 */
class Unit implements UnitInterface
{
    private readonly string $socket;

    private readonly string $address;

    private Config $_config;

    private mixed $_certificates;

    public function __construct(string $socket, string $address)
    {
        $this->socket = $socket;
        $this->address = $address;

        $this->loadConfig();
    }

    /**
     * Return full config uploaded on Nginx Unit
     *
     * @return Config
     * @throws \Exception
     */
    public function getConfig(): Interfaces\ConfigInterface
    {
        if (empty($this->_config)) {
            $this->loadConfig();
        }

        return $this->_config;
    }

    /**
     * Download config from Unit
     *
     * @return void
     * @throws \Exception
     */
    private function loadConfig()
    {
        $request = new UnitRequest($this->socket, $this->address);
        $result = $request->send('/config');
        $this->_config = new Config($result);
    }

    /**
     * Return array of certificates uploaded on Unit
     *
     * @return mixed
     */
    public function getCertificates(): array
    {
        $request = new UnitRequest($this->socket, $this->address);

        return $request->send('/certificates');
    }

    /**
     * Return Unit socket
     *
     * @return string
     */
    public function getSocket(): string
    {
        return $this->socket;
    }

    /**
     * Return Unit address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Return Usage Statistics from Unit
     *
     * @return Interfaces\StatisticsInterface
     * @throws UnitException
     */
    public function getStatistics(): Interfaces\StatisticsInterface
    {
        $result = (new UnitRequest($this->socket, $this->address))->send('/status');

        return new Statistic($result);
    }
}

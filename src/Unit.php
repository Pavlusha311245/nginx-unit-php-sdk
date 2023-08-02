<?php

namespace Pavlusha311245\UnitPhpSdk;

use Pavlusha311245\UnitPhpSdk\Config\AccessLog;
use Pavlusha311245\UnitPhpSdk\Config\Statistics;
use Pavlusha311245\UnitPhpSdk\Enums\HttpMethodsEnum;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;
use Pavlusha311245\UnitPhpSdk\Interfaces\UnitInterface;

/**
 * This is main class of Nginx Unit manipulation
 */
class Unit implements UnitInterface
{
    private Config $_config;

    private array $_certificates;

    private Statistics $_statistics;

    /**
     * @throws UnitException
     */
    public function __construct(
        private readonly string $socket,
        private readonly string $address
    ) {
        $this->loadConfig();
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function getConfig(): Interfaces\ConfigInterface
    {
        $this->loadConfig();

        return $this->_config;
    }

    /**
     * Download config from Unit
     *
     * @return void
     * @throws UnitException
     */
    private function loadConfig(): void
    {
        $request = new UnitRequest($this->socket, $this->address);
        $result = $request->send('/config');
        $this->_config = new Config($result);
    }

    /**
     * @inheritDoc
     *
     */
    public function getCertificates(): array
    {
        $this->loadCertificates();

        return $this->_certificates;
    }

    private function loadCertificates()
    {
        $request = new UnitRequest($this->socket, $this->address);
        $result = $request->send('/certificates');
        foreach ($result as $key => $value) {
            $this->_certificates[$key] = new Certificate($value, $key);
        }
    }

    /**
     * @inheritDoc
     */
    public function getSocket(): string
    {
        return $this->socket;
    }

    /**
     * @inheritDoc
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @inheritDoc
     */
    public function getStatistics(): Interfaces\StatisticsInterface
    {
        $this->loadStatistics();

        return $this->_statistics;
    }

    private function loadStatistics(): void
    {
        $result = (new UnitRequest($this->socket, $this->address))->send('/status');
        $this->_statistics = new Statistics($result);
    }

    /**
     * @inheritDoc
     */
    public function getCertificate($certificateName): ?Certificate
    {
        $this->loadCertificates();

        return $this->_certificates[$certificateName] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function removeConfig(): bool
    {
        try {
            $request = new UnitRequest($this->socket, $this->address);
            $request->setMethod(HttpMethodsEnum::DELETE->value);
            $request->send('/config');
        } catch (UnitException $exception) {
            return false;
        }

        return true;
    }
}

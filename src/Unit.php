<?php

namespace Pavlusha311245\UnitPhpSdk;

use Pavlusha311245\UnitPhpSdk\Config\AccessLog;
use Pavlusha311245\UnitPhpSdk\Config\Statistics;
use Pavlusha311245\UnitPhpSdk\Enums\HttpMethodsEnum;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;
use Pavlusha311245\UnitPhpSdk\Http\UnitRequest;
use Pavlusha311245\UnitPhpSdk\Interfaces\CertificateInterface;
use Pavlusha311245\UnitPhpSdk\Interfaces\UnitInterface;

/**
 * This is main class of Nginx Unit manipulation
 */
class Unit implements UnitInterface
{
    /**
     * Contains Config object
     *
     * @var Config
     */
    private Config $_config;

    /**
     * Contains array of Certificate objects
     *
     * @var array
     */
    private array $_certificates;

    /**
     * Contains Statistics object
     *
     * @var Statistics
     */
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
        $result = $request->send('/config', false);
        $this->_config = new Config($result, new UnitRequest($this->socket, $this->address));
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

    /**
     * @inheritDoc
     */
    public function uploadCertificate(string $path, string $certificateName): bool
    {
        // TODO: need to review
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new UnitException('Fail to read certificate');
        }

        try {
            $request = new UnitRequest($this->socket, $this->address);
            $request->setMethod('PUT');
            $request->setData($fileContent);
            $result = $request->send("/certificates/{$certificateName}");
        } catch (UnitException $exception) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function removeCertificate(string $certificateName): bool
    {
        // TODO: need to review
        try {
            $request = new UnitRequest($this->socket, $this->address);
            $request->setMethod('DELETE');
            $result = $request->send("/certificates/{$certificateName}");
        } catch (UnitException $exception) {
            return false;
        }

        return true;
    }

    private function loadCertificates(): void
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
    public function getCertificate(string $certificateName): ?CertificateInterface
    {
        $this->loadCertificates();

        return $this->_certificates[$certificateName] ?? null;
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function uploadConfig(string $path): bool
    {
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new UnitException('Fail to read certificate');
        }

        if (!json_decode($fileContent, true)) {
            throw new UnitException('File is not JSON format');
        }

        try {
            $request = new UnitRequest($this->socket, $this->address);
            $request->setMethod('PUT');
            $request->setData($fileContent);
            $result = $request->send("/config");
        } catch (UnitException $exception) {
            print_r($exception->getMessage());
            return false;
        }

        return true;
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

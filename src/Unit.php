<?php

namespace UnitPhpSdk;

use UnitPhpSdk\Contracts\{CertificateInterface, UnitInterface};
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Exceptions\FileNotFoundException;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Statistics\Statistics;

/**
 * This is main class of Nginx Unit manipulation
 *
 * @implements UnitInterface
 */
class Unit implements UnitInterface
{
    /**
     * Contains Config object
     *
     * @var Config
     */
    private Config $config;

    /**
     * Contains array of Certificate objects
     *
     * @var array
     */
    private array $certificates;

    /**
     * Contains Statistics object
     *
     * @var Statistics
     */
    private Statistics $statistics;

    /**
     * @throws UnitException
     */
    public function __construct(
        private readonly string  $address,
        private readonly ?string $socket = null
    )
    {
        $this->loadConfig();
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function getConfig(): Contracts\ConfigInterface
    {
        $this->loadConfig();

        return $this->config;
    }

    /**
     * Download config from Unit
     *
     * @return void
     * @throws UnitException
     */
    private function loadConfig(): void
    {
        $request = new UnitRequest($this->address, $this->socket);
        $result = $request->send('/config', false);
        $this->config = new Config($result, new UnitRequest($this->address, $this->socket));
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function getCertificates(): array
    {
        $this->loadCertificates();

        return $this->certificates;
    }

    /**
     * @inheritDoc
     */
    public function uploadCertificate(string $path, string $certificateName): bool
    {
        // TODO: need to review
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new FileNotFoundException();
        }

        try {
            $request = new UnitRequest($this->address, $this->socket);
            $request->setMethod('PUT');
            $request->setData($fileContent);
            $request->send("/certificates/$certificateName");
        } catch (UnitException $exception) {
            print_r($exception->getMessage());
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
            $request = new UnitRequest($this->address, $this->socket);
            $request->setMethod('DELETE');
            $request->send("/certificates/$certificateName");
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * @throws UnitException
     */
    private function loadCertificates(): void
    {
        $request = new UnitRequest($this->address, $this->socket);
        $result = $request->send('/certificates');
        foreach ($result as $key => $value) {
            $this->certificates[$key] = new Certificate($value, $key);
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
    public function getStatistics(): Contracts\StatisticsInterface
    {
        $this->loadStatistics();

        return $this->statistics;
    }

    /**
     * @throws UnitException
     */
    private function loadStatistics(): void
    {
        $result = (new UnitRequest($this->address, $this->socket))->send('/status');
        $this->statistics = new Statistics($result);
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function getCertificate(string $certificateName): ?CertificateInterface
    {
        $this->loadCertificates();

        return $this->certificates[$certificateName] ?? null;
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function uploadConfigFromFile(string $path): bool
    {
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new FileNotFoundException();
        }

        $data = json_decode($fileContent, true);

        if (!$data) {
            throw new UnitException('File is not JSON format');
        }

        try {
            $request = new UnitRequest($this->address, $this->socket);
            $request
                ->setMethod('PUT')
                ->send("/config", true, [
                    'form_params' => $data
                ]);
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
            $request = new UnitRequest($this->address, $this->socket);
            $request
                ->setMethod(HttpMethodsEnum::DELETE->value)
                ->send('/config');
        } catch (UnitException) {
            return false;
        }

        return true;
    }
}

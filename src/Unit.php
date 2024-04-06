<?php

namespace UnitPhpSdk;

use UnitPhpSdk\Contracts\{CertificateInterface, UnitInterface, Uploadable};
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
    private array $certificates = [];

    /**
     * Contains Statistics object
     *
     * @var Statistics
     */
    private Statistics $statistics;

    /**
     * @var array $js_modules List of JavaScript modules
     */
    private array $js_modules = [];

    private UnitRequest $request;

    /**
     * @throws UnitException
     */
    public function __construct(
        private readonly string  $address,
        private readonly ?string $socket = null
    ) {
        $this->request = new UnitRequest(
            address: $this->address,
            socket: $this->socket
        );

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
        $result = $this->request->send('/config', false);
        $this->config = new Config($result, $this->request);
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
            $this->request->setMethod('PUT')
                ->send("/certificates/$certificateName", requestOptions: [
                    'body' => $fileContent
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
    public function removeCertificate(string $certificateName): bool
    {
        // TODO: need to review
        try {
            $this->request
                ->setMethod('DELETE')
                ->send("/certificates/$certificateName");
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
        $result = $this->request->send('/certificates');
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
     * @return array
     */
    public function getJsModules(): array
    {
        $this->loadJsModules();

        return $this->js_modules;
    }

    /**
     * @param array $js_modules
     */
    public function setJsModules(array $js_modules): void
    {
        $this->js_modules = $js_modules;
    }

    private function loadJsModules(): void
    {
        $result = $this->request->send('/js_modules');

        foreach ($result as $key => $value) {
            $this->js_modules[$key] = new JsModule($key, $value);
        }
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

    public function uploadConfig(Config $config): bool
    {
        return true;
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
            $this->request
                ->setMethod('PUT')
                ->send(uri: "/config", requestOptions: [
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
            $this->request
                ->setMethod(HttpMethodsEnum::DELETE->value)
                ->send('/config');
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * Uploads the specified Uploadable object.
     *
     * @param Uploadable $object
     */
    public function upload(Uploadable $object): void
    {
        $object->upload($this->request);
    }

    /**
     * Removes an Uploadable object.
     *
     * @param Uploadable $object The Uploadable object to be removed.
     *
     * @return void
     */
    public function remove(Uploadable $object): void
    {
        $object->remove($this->request);
    }
}

<?php

namespace UnitPhpSdk;

use UnitPhpSdk\Contracts\{CertificateInterface, UnitInterface, Uploadable};
use Override;
use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Config\Listener;
use UnitPhpSdk\Config\Route;
use UnitPhpSdk\Config\Upstream;
use UnitPhpSdk\Enums\ApiPathEnum;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Exceptions\FileNotFoundException;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Http\UnitHttpClient;
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Statistics\Statistics;

/**
 * This is main class of Nginx Unit manipulation
 *
 * @implements UnitInterface
 * @property Config $config
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

    private UnitHttpClient $client;


    /**
     * Constructor
     *
     * @throws UnitException
     */
    public function __construct(
        private readonly string  $address,
        private readonly ?string $socket = null,
    )
    {
        $this->request = new UnitRequest(
            address: $this->address,
            socket: $this->socket
        );

        $this->client = new UnitHttpClient(
            baseUrl: $this->address,
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
        $result = $this->request->send(ApiPathEnum::CONFIG->value, false);

        $this->config = new Config($result, $this->request);
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function getCertificates(): array
    {
        try {
            $this->loadCertificates();

            return $this->certificates;
        } catch (UnitException $exception) {
            if ($exception->getCode() == 404) {
                return [];
            }

            throw new UnitException($exception->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function uploadCertificate(string $path, string $certificateName)
    {
        // TODO: need to review
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new FileNotFoundException();
        }

        try {
            $this->request->setMethod(HttpMethodsEnum::PUT)
                ->send(ApiPathEnum::CERTIFICATE->getPath($certificateName), requestOptions: [
                    'body' => $fileContent
                ]);
        } catch (\Throwable $exception) {
            if ($exception->getCode() == 400) {
                throw new UnitException($exception->getMessage());
            }

            throw new UnitException($exception->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function removeCertificate(string $certificateName): bool
    {
        // TODO: need to review
        try {
            $this->request
                ->setMethod(HttpMethodsEnum::DELETE)
                ->send(ApiPathEnum::CERTIFICATE->getPath($certificateName));

            return true;
        } catch (UnitException $exception) {
            if ($exception->getCode() == 404) {
                throw new UnitException('Certificate not found');
            }

            throw new UnitException($exception->getMessage());
        }
    }

    /**
     * @throws UnitException
     */
    private function loadCertificates(): void
    {
        $result = $this->request->send(ApiPathEnum::CERTIFICATES->value);
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
     * @throws UnitException
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

    /**
     * @throws UnitException
     */
    private function loadJsModules(): void
    {
        try {
            $result = $this->request->send(ApiPathEnum::JS_MODULES->value);

            foreach ($result as $key => $value) {
                $this->js_modules[$key] = new JsModule($key, $value);
            }
        } catch (UnitException $exception) {
            $this->js_modules = [];
        }
    }

    /**
     * @throws UnitException
     */
    private function loadStatistics(): void
    {
        $result = $this->request->send(ApiPathEnum::STATUS->value);
        $this->statistics = new Statistics($result);
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function getCertificate(string $certificateName): ?CertificateInterface
    {
        try {
            $this->loadCertificates();

            return $this->certificates[$certificateName];
        } catch (UnitException $exception) {
            if ($exception->getCode() == 404) {
                throw new UnitException('Certificate not found');
            }

            throw new UnitException($exception->getMessage());
        }
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
                ->setMethod(HttpMethodsEnum::PUT)
                ->send(uri: ApiPathEnum::CONFIG->value, requestOptions: [
                    'form_params' => $data
                ]);
        } catch (UnitException $exception) {
            print_r($exception->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Uploads the specified Uploadable objects.
     *
     * @param Uploadable ...$objects
     */
    public function upload(Uploadable ...$objects): void
    {
        foreach ($objects as $object) {
            $object->upload($this->request);
        }
    }

    /**
     * Removes an Uploadable objects.
     *
     * @param Uploadable ...$objects
     * @return void
     */
    public function remove(Uploadable ...$objects): void
    {
        foreach ($objects as $object) {
            $object->remove($this->request);
        }
    }

    /**
     * Restarts the given application.
     *
     * @param AbstractApplication $application The application to be restarted.
     * @return bool Returns true if the application was restarted successfully, false otherwise.
     * @throws UnitException
     */
    public function restartApplication(AbstractApplication $application): bool
    {
        try {
            $this->request->send(ApiPathEnum::APPLICATION_RESET->getPath($application->getName()));
        } catch (UnitException $e) {
            if ($e->getCode() == 404) {
                throw new UnitException('Application not found');
            }

            return false;
        }

        return true;
    }

    /**
     * @throws UnitException
     */
    #[Override] public function toArray(): array
    {
        return [
            'certificates' => array_map(fn($certificate) => $certificate->toArray(), $this->getCertificates()),
            'config' => $this->getConfig()->toArray(),
            'js_modules' => array_map(fn($module) => $module->toArray(), $this->getJsModules()),
            'status' => $this->getStatistics()->toArray()
        ];
    }

    /**
     * Checks if a connection to the server is established.
     *
     * @return bool Returns true if the connection is successful, false otherwise.
     */
    public function isConnected(): bool
    {
        try {
            $this->request->send(ApiPathEnum::UNIT->value);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    #[Override] public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}

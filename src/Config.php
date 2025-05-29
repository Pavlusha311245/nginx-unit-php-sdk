<?php

namespace UnitPhpSdk;

use Override;
use Throwable;
use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Config\{AccessLog, Listener, Route, Settings, Upstream, Upstream\Server};
use UnitPhpSdk\Exceptions\{FileNotFoundException, UnitException};
use UnitPhpSdk\Builders\ApplicationBuilder;
use UnitPhpSdk\Builders\EndpointBuilder;
use UnitPhpSdk\Contracts\ConfigInterface;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Enums\ApiPathEnum;
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Traits\CanUpload;

/**
 * This class contains Nginx Unit config data
 *
 * @implements ConfigInterface
 */
class Config implements ConfigInterface, Uploadable
{
    use CanUpload;

    /**
     * Listeners that accept requests
     *
     * @var array
     */
    private array $listeners = [];

    /**
     * Route entities defines internal request routing.
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Each app that Unit runs is defined as an object
     *
     * @var array
     */
    private array $applications = [];

    /**
     * An upstream is a group of servers that comprise a single logical entity and
     * may be used as a pass destination for incoming requests in a listener or a route.
     *
     * @var array|mixed
     */
    private array $upstreams = [];

    /**
     * @var Settings|null
     */
    private ?Settings $settings = null;

    private ?UnitRequest $unitRequest;

    /**
     * Constructor
     *
     * @param object|null $data
     * @throws UnitException
     */
    public function __construct(object $data = null, UnitRequest $unitRequest = null)
    {
        $this->unitRequest = $unitRequest;

        if (!empty($data)) {
            $this->parseUnitObject($data);
        }

        $this->setApiEndpoint(ApiPathEnum::CONFIG->value);
    }

    /**
     * @param string $json
     * @return void
     * @throws UnitException
     */
    public function parseJson(string $json): void
    {
        $this->parseUnitObject(json_decode($json, false));
    }

    /**
     * @throws UnitException
     */
    private function parseUnitObject(object $data): void
    {
        $rawData = $data;
        $jsonData = json_decode(json_encode($data), true);

        $this->parseRoutes($rawData);
        $this->parseApplications($jsonData);
        $this->parseUpstreams($jsonData);
        $this->parseListeners($jsonData);
        $this->parseSettings($jsonData);
    }

    private function parseSettings($jsonData): void
    {
        if (array_key_exists('settings', $jsonData)) {
            $this->settings = new Settings($jsonData['settings']);
        }
    }

    /**
     * Fill data if listeners key exists
     *
     * @param array $data
     * @return void
     * @throws UnitException
     */
    public function parseListeners(array $data): void
    {
        if (array_key_exists('listeners', $data)) {
            foreach ($data['listeners'] as $listener => $listenerData) {
                $listener = (new Listener(
                    listener: $listener,
                    pass: $listenerData['pass']
                ))->parseFromArray($listenerData);

                $typePath = $listener->getPass()->getType();
                $typePathName = $listener->getPass()->getName();

                ($this->{"$typePath"}[$typePathName ?? 'default'])?->setListener($listener);

                $this->listeners[] = $listener;
            }
        }
    }


    /**
     * Fill data if applications key exists
     *
     * @param array $data
     * @return void
     * @throws UnitException
     */
    public function parseApplications(array $data): void
    {
        if (array_key_exists('applications', $data)) {
            foreach ($data['applications'] as $appName => $appData) {
                $this->applications[$appName] = ApplicationBuilder::create($appName, $appData, $appData['type']);
            }
        }
    }

    /**
     * Detect if NodeJsExternalApplication
     *
     * @param $appData
     * @return bool
     */
    private function isNodeJsApplication($appData): bool
    {
        if (array_key_exists('arguments', $appData)) {
            foreach ($appData['arguments'] as $argument) {
                if (str_contains($argument, '.js')) {
                    return true;
                }
            }
        }

        if (str_contains($appData['executable'], '.js')) {
            return true;
        }

        return false;
    }

    /**
     * Fill data if routes key exists
     *
     * @param object $rawData
     * @return void
     * @throws UnitException
     */
    public function parseRoutes(object $rawData): void
    {
        if (!empty($rawData->routes)) {
            $jsonRoutes = json_decode(json_encode($rawData), true)['routes'];
            if (!is_array($rawData->routes)) {
                foreach ($jsonRoutes as $routeName => $routeData) {
                    $this->routes[$routeName] = new Route($routeName, $routeData);
                }
            } else {
                $this->routes['default'] = new Route('default', $jsonRoutes[0], true);
            }
        }
    }

    /**
     * Fill data if upstreams key exists
     *
     * @param array $data
     * @return void
     * @throws UnitException
     */
    public function parseUpstreams(array $data): void
    {
        if (array_key_exists('upstreams', $data)) {
            foreach ($data['upstreams'] as $upstreamName => $upstreamData) {
                if (!array_key_exists('servers', $upstreamData)) {
                    throw new UnitException('Servers key not found in upstream data');
                }

                $servers = array_map(
                    fn ($v, $k) => new Server($v, $k['weight'] ?? 1),
                    array_keys($upstreamData['servers']),
                    array_values($upstreamData['servers'])
                );

                $this->upstreams[$upstreamName] = new Upstream($upstreamName, $servers);
            }
        }
    }

    /**
     * @param string $listener
     * @return Listener|null
     */
    public function getListener(string $listener): ?Listener
    {
        return array_find($this->listeners, fn (Listener $item) => $item->getListener() == $listener);
    }

    /**
     * Get listener by port
     *
     * @param int $port
     * @return Listener|null
     */
    public function getListenerByPort(int $port): Listener|null
    {
        foreach ($this->listeners as $listener) {
            if ($listener->getPort() == $port) {
                return $listener;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function uploadListener(Listener $listener): bool
    {
        try {
            $this->unitRequest->setMethod(HttpMethodsEnum::PUT)
                ->send(
                    uri: "/config/listeners/{$listener->getListener()}",
                    requestOptions: [
                        'json' => $listener->toArray()
                    ]
                );
        } catch (UnitException $e) {
            print_r($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @throws UnitException
     */
    public function uploadListenerFromFile(string $path, string $listenerName): bool
    {
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new FileNotFoundException();
        }

        if (!json_validate($fileContent)) {
            throw new UnitException('It\'s not a JSON file');
        }

        try {
            $this->unitRequest->setMethod(HttpMethodsEnum::PUT)
                ->send(ApiPathEnum::LISTENER->getPath($listenerName), requestOptions: [
                    'body' => $fileContent
                ]);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * Remove listener
     *
     * @throws UnitException
     */
    public function removeListener(Listener $listener): bool
    {
        $listenerName = $listener->getListener();
        $this->unitRequest
            ->setMethod(HttpMethodsEnum::DELETE)
            ->send(ApiPathEnum::LISTENER->getPath($listenerName));

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getListeners(): array
    {
        return $this->listeners ?? [];
    }

    /**
     * Get applications from config
     *
     * @return array
     */
    public function getApplications(): array
    {
        return $this->applications;
    }

    /**
     * Get application from config by name
     *
     * @param $applicationName
     * @return AbstractApplication|null
     */
    public function getApplication($applicationName): ?AbstractApplication
    {
        return $this->applications[$applicationName] ?? null;
    }

    /**
     * @throws UnitException
     */
    public function uploadApplication(AbstractApplication $application, string $name = ''): bool
    {
        if (empty($application->getName()) && empty($name)) {
            throw new UnitException('Application name not specified');
        }

        $applicationName = empty($application->getName()) ? $name : $application->getName();

        try {
            $this->unitRequest
                ->setMethod(HttpMethodsEnum::PUT)
                ->send(ApiPathEnum::APPLICATION->getPath($applicationName), requestOptions: [
                    'json' => $application->toJson()
                ]);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     * @throws UnitException
     */
    public function uploadApplicationFromFile(string $path, string $applicationName): bool
    {
        // TODO: add validation if json contains application name
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new FileNotFoundException();
        }

        if (!json_validate($fileContent)) {
            throw new UnitException('It\'s not a JSON file');
        }

        try {
            $this->unitRequest
                ->setMethod(HttpMethodsEnum::PUT)
                ->send(ApiPathEnum::APPLICATION->getPath($applicationName), requestOptions: [
                    'body' => $fileContent
                ]);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * Remove application from Nginx Unit.
     * Cain receive application name or application object
     *
     * @throws UnitException
     */
    public function removeApplication(AbstractApplication|string $application): bool
    {
        $applicationName = is_string($application) ? $application : $application->getName();
        $this->unitRequest
            ->setMethod(HttpMethodsEnum::DELETE)
            ->send(ApiPathEnum::APPLICATION->getPath($applicationName));

        return true;
    }

    /**
     * Get routes from config
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Get route from config by name
     *
     * @param string $routeName
     * @return Route|null
     */
    public function getRoute(string $routeName): Route|null
    {
        return $this->routes[$routeName] ?? null;
    }

    /**
     * @throws UnitException
     */
    public function removeRoutes(): bool
    {
        foreach ($this->getRoutes() as $route) {
            if ($route->hasListeners()) {
                foreach ($route->getListeners() as $listener) {
                    $this->removeListener($listener);
                }
            }
        }

        try {
            $this->unitRequest->setMethod(HttpMethodsEnum::DELETE)
                ->send(ApiPathEnum::ROUTES->value);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    public function removeRoute(Route|string $route): bool
    {
        // TODO: should be implemented

        return false;
    }

    /**
     * Get upstreams
     *
     * @return array
     */
    public function getUpstreams(): array
    {
        return $this->upstreams;
    }

    /**
     * @param $name
     * @return Upstream
     */
    public function getUpstream($name): Upstream
    {
        return $this->upstreams[$name];
    }

    /**
     * @inheritDoc
     * @throws UnitException
     */
    public function uploadUpstream(Upstream $upstream, string $name = ''): bool
    {
        if (empty($upstream->getName()) && empty($name)) {
            throw new UnitException('Name isn\'t be empty');
        }

        $upstreamName = empty($upstream->getName()) ? $name : $upstream->getName();

        try {
            $this->unitRequest
                ->setMethod(HttpMethodsEnum::PUT)
                ->send(ApiPathEnum::UPSTREAM->getPath($upstreamName), requestOptions: [
                    'json' => $upstream->toArray()
                ]);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * @throws UnitException
     * @throws FileNotFoundException
     */
    public function uploadUpstreamsFromFile(string $path): bool
    {
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new FileNotFoundException();
        }

        if (!json_validate($fileContent)) {
            throw new UnitException('It\'s not a JSON file');
        }

        try {
            $this->unitRequest
                ->setMethod(HttpMethodsEnum::PUT)
                ->send(ApiPathEnum::UPSTREAMS, requestOptions: [
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
    public function setAccessLog($path, $format = null): bool
    {
        $data['path'] = $path;

        if (!empty($format)) {
            $data['format'] = $format;
        }

        try {
            $this->unitRequest->setMethod(HttpMethodsEnum::PUT)
                ->send(ApiPathEnum::ACCESS_LOG->value, requestOptions: [
                    'json' => $data
                ]);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * Add access log to config
     *
     * @return AccessLog|null
     */
    public function getAccessLog(): ?AccessLog
    {
        try {
            $result = $this->unitRequest->send(ApiPathEnum::ACCESS_LOG->value);

            return new AccessLog($result);
        } catch (Throwable $exception) {
//            TODO: add for all 404 normal exception

            return null;
        }
    }

    public function removeAccessLog(): bool
    {
        try {
            $this->unitRequest
                ->setMethod(HttpMethodsEnum::DELETE)
                ->send(ApiPathEnum::ACCESS_LOG->value);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * Return config as array
     *
     * @return array
     */
    #[Override] public function toArray(): array
    {
        $data = [
            'listeners' => $this->mapConfigObjectToArray($this->listeners),
            'routes' => $this->mapConfigObjectToArray($this->routes),
            'applications' => $this->mapConfigObjectToArray($this->applications),
            'upstreams' => $this->mapConfigObjectToArray($this->upstreams),
            'settings' => $this->settings?->toArray()
        ];

        if (!empty($this->settings)) {
            $data = array_merge($data, $this->settings->toArray());
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function mapConfigObjectToArray(array $data): array
    {
        $keys = array_map(fn ($item) => $item->getName(), $data);
        $values = array_map(fn ($item) => $item->toArray(), $data);

        return array_combine($keys, $values);
    }

    public function reset(): bool
    {
        try {
            $this->unitRequest->setMethod(HttpMethodsEnum::DELETE)
                ->send(ApiPathEnum::CONFIG->value);

            $this->unitRequest->setMethod(HttpMethodsEnum::POST)
                ->send(
                    uri: ApiPathEnum::CONFIG->value,
                    requestOptions: [
                    'json' => json_encode([
                        'listeners' => (object)[],
                        'routes' => (object)[],
                        'applications' => (object)[],
                        'upstreams' => (object)[],
                        'settings' => (object)[]
                    ])
                ]
                );
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    /**
     * @return Settings|null
     */
    public function getSettings(): ?Settings
    {
        return $this->settings;
    }

    /**
     * @param Settings $settings
     */
    public function setSettings(Settings $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @param int $options
     * @return string
     */
    #[Override] public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray());
    }
}

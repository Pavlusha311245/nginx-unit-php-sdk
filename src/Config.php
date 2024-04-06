<?php

namespace UnitPhpSdk;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Config\{AccessLog, Application, Listener, Route, Settings, Upstream, Upstream\Server};
use UnitPhpSdk\Exceptions\{FileNotFoundException, UnitException};
use UnitPhpSdk\Contracts\{Arrayable, ConfigInterface, Jsonable};
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Enums\HttpMethodsEnum;

/**
 * This class contains Nginx Unit config data
 *
 * @implements ConfigInterface
 */
class Config implements ConfigInterface, Arrayable, Jsonable
{
    /**
     * Listeners that accept requests
     *
     * @var array
     */
    private array $listeners;

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
     * @var Settings
     */
    private Settings $settings;

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

        if (!empty($data) && !empty($this->unitRequest)) {
            $this->parseUnitObject($data);
        }
    }

    /**
     * @throws UnitException
     */
    private function parseUnitObject(object $data): void
    {
        $rawData = $data;
        $jsonData = json_decode(json_encode($data), true);

        $this->loadRoutes($rawData);
        $this->loadApplications($jsonData);
        $this->loadUpstreams($jsonData);
        $this->loadListeners($jsonData);
        $this->loadSettings($jsonData);
    }

    private function loadSettings($jsonData): void
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
    public function loadListeners(array $data): void
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
    public function loadApplications(array $data): void
    {
        if (array_key_exists('applications', $data)) {
            foreach ($data['applications'] as $appName => $appData) {
                $this->applications[$appName] = (match ($appData['type']) {
                    'php' => new Application\PhpApplication($appData),
                    'java' => new Application\JavaApplication($appData),
                    'perl' => new Application\PerlApplication($appData),
                    'python' => new Application\PythonApplication($appData),
                    'wasm' => new Application\WebAssemblyApplication($appData),
                    'ruby' => new Application\RubyApplication($appData),
                    'wasm-wasi-component' => new Application\WebAssemblyComponentApplication($appData),
                    'external' => $this->isNodeJsApplication($appData) ?
                        new Application\NodeJsExternalApplication($appData) :
                        new Application\GoExternalApplication($appData),
                })
                    ->setName($appName)
                    ->setUnitRequest($this->unitRequest);
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
     */
    public function loadRoutes(object $rawData): void
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
     */
    public function loadUpstreams(array $data): void
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
        return $this->listeners[$listener] ?? null;
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
            $this->unitRequest->setMethod(HttpMethodsEnum::PUT->value)
                ->send("/config/listeners/{$listener->getListener()}", requestOptions: [
                    'json' => $listener->toArray()
                ]);
        } catch (UnitException $e) {
            print_r($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @throws UnitException
     */
    public function uploadListenerFromFile(string $path, string $listener): bool
    {
        $fileContent = file_get_contents($path);

        if (!$fileContent) {
            throw new FileNotFoundException();
        }

        if (!json_validate($fileContent)) {
            throw new UnitException('It\'s not a JSON file');
        }

        try {
            $this->unitRequest->setMethod('PUT')
                ->send("/config/listeners/$listener", requestOptions: [
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
        $listenerId = $listener->getListener();
        $this->unitRequest
            ->setMethod(HttpMethodsEnum::DELETE->value)
            ->send("/config/listeners/$listenerId");

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

        $appName = empty($application->getName()) ? $name : $application->getName();

        try {
            $this->unitRequest
                ->setMethod(HttpMethodsEnum::PUT->value)
                ->send("/config/applications/$appName", requestOptions: [
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
    public function uploadApplicationFromFile(string $path, string $name): bool
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
                ->setMethod(HttpMethodsEnum::PUT->value)
                ->send("/config/applications/$name", requestOptions: [
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
            ->setMethod(HttpMethodsEnum::DELETE->value)
            ->send("/config/applications/$applicationName");

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
            $this->unitRequest->setMethod(HttpMethodsEnum::DELETE->value)
                ->send('/config/routes');
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
                ->setMethod(HttpMethodsEnum::PUT->value)
                ->send("/config/upstreams/$upstreamName", requestOptions: [
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
                ->setMethod(HttpMethodsEnum::PUT->value)
                ->send('/config/upstreams', requestOptions: [
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
            $this->unitRequest->setMethod(HttpMethodsEnum::PUT->value)
                ->send('/config/access_log', requestOptions: [
                    'json' => json_encode($data)
                ]);
        } catch (UnitException) {
            return false;
        }

        return true;
    }

    public function getAccessLog(): ?AccessLog
    {
        try {
            $result = $this->unitRequest->send('/config/access_log');
        } catch (UnitException) {
            return null;
        }

        return new AccessLog($result);
    }

    public function removeAccessLog(): bool
    {
        try {
            $this->unitRequest
                ->setMethod(HttpMethodsEnum::DELETE->value)
                ->send('/config/access_log');
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
    #[\Override] public function toArray(): array
    {
        $array = [];

        foreach (array_keys(get_object_vars($this)) as $key) {
            if (!empty($this->{$key})) {
                $array[substr($key, 1)] = $this->{$key};
            }
        }

        return $array;
    }

    /**
     * @return Settings
     */
    public function getSettings(): Settings
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
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toJson());
    }
}

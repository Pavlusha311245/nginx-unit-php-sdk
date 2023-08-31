<?php

namespace Pavlusha311245\UnitPhpSdk;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Config\{
    Application,
    Listener,
    Route,
    Upstream,
    AccessLog
};
use Pavlusha311245\UnitPhpSdk\Enums\HttpMethodsEnum;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;
use Pavlusha311245\UnitPhpSdk\Interfaces\ConfigInterface;

/**
 * This class contains Nginx Unit config data
 */
class Config implements ConfigInterface
{
    /**
     * Listeners accept requests
     *
     * @var array
     */
    private array $_listeners;

    /**
     * Route entities defines internal request routing.
     *
     * @var array
     */
    private array $_routes = [];

    /**
     * Each app that Unit runs is defined as an object
     *
     * @var array
     */
    private array $_applications = [];

    /**
     * An upstream is a group of servers that comprise a single logical entity and
     * may be used as a pass destination for incoming requests in a listener or a route.
     *
     * @var array|mixed
     */
    private array $_upstreams = [];

    /**
     * Constructor
     *
     * @throws UnitException
     */
    public function __construct(object $data, private readonly UnitRequest $_unitRequest)
    {
        $rawData = $data;
        $jsonData = json_decode(json_encode($data), true);

        $this->loadRoutes($rawData);
        $this->loadApplications($jsonData);
        $this->loadUpstreams($jsonData);
        $this->loadListeners($jsonData);
    }

    /**
     * @param array $data
     * @return void
     * @throws UnitException
     */
    public function loadListeners(array $data): void
    {
        if (array_key_exists('listeners', $data)) {
            foreach ($data['listeners'] as $listener => $listenerData) {
                $listener = (new Listener(
                    _listener: $listener,
                    pass: $listenerData['pass']
                ))->parseFromArray($listenerData);

                $typePath = $listener->getPass()->getPassType();
                $typePathName = $listener->getPass()->toArray()[1] ?? null;

                ($this->{"_{$typePath}"}[$typePathName ?? 'default'])?->setListener($listener);

                $this->_listeners[] = $listener;
            }
        }
    }


    /**
     * @param array $data
     * @return void
     * @throws UnitException
     */
    public function loadApplications(array $data): void
    {
        if (array_key_exists('applications', $data)) {
            foreach ($data['applications'] as $appName => $appData) {
                // TODO: implement Perl, Python and Ruby applications
                $this->_applications[$appName] = match ($appData['type']) {
                    'php' => new Application\PhpApplication($appData),
                    'java' => new Application\JavaApplication($appData),
                    'external' => $this->isNodeJsApplication($appData) ? new Application\NodeJsApplication($appData) : new Application\GoApplication($appData),
                };
                $this->_applications[$appName]->setName($appName);
                $this->_applications[$appName]->setUnitRequest($this->_unitRequest);
            }
        }
    }

    /**
     * @param $appData
     * @return bool
     */
    public function isNodeJsApplication($appData): bool
    {
        foreach ($appData['arguments'] as $argument) {
            if (str_contains($argument, '.js')) {
                return true;
            }
        }

        if (str_contains($appData['executable'], '.js')) {
            return true;
        }

        return false;
    }

    public function loadRoutes(object $rawData): void
    {
        if (!empty($rawData->routes)) {
            $jsonRoutes = json_decode(json_encode($rawData), true)['routes'];
            if (!is_array($rawData->routes)) {
                foreach ($jsonRoutes as $routeName => $routeData) {
                    $this->_routes[$routeName] = new Route($routeName, $routeData);
                }
            } else {
                $this->_routes['default'] = new Route('default', $jsonRoutes[0], true);
            }
        }
    }

    /**
     * @param array $data
     * @return void
     */
    public function loadUpstreams(array $data): void
    {
        if (array_key_exists('upstreams', $data)) {
            foreach ($data['upstreams'] as $upstreamName => $upstreamData) {
                $this->_upstreams[$upstreamName] = new Upstream($upstreamName, $upstreamData);
            }
        }
    }

    /**
     * @param string $listener
     * @return Listener|null
     */
    public function getListener(string $listener): ?Listener
    {
        return $this->_listeners[$listener] ?? null;
    }

    /**
     * Get listener by port
     *
     * @param int $port
     * @return Listener|null
     */
    public function getListenerByPort(int $port): Listener|null
    {
        foreach ($this->_listeners as $listener) {
            if ($listener->getPort() == $port) {
                return $listener;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function addListener(Listener $listener): bool
    {
        try {
            $this->_unitRequest->setMethod(HttpMethodsEnum::PUT->value);
            $this->_unitRequest->setData($listener->toJson());
            $this->_unitRequest->send("/config/listeners/{$listener->getListener()}");
        } catch (UnitException $exception) {
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
        $this->_unitRequest->setMethod(HttpMethodsEnum::DELETE->value);

        $listenerId = $listener->getListener();
        $this->_unitRequest->send("/config/listeners/{$listenerId}");

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getListeners(): array
    {
        return $this->_listeners ?? [];
    }

    /**
     * Get applications from config
     *
     * @return array
     */
    public function getApplications(): array
    {
        return $this->_applications;
    }

    /**
     * Get application from config by name
     *
     * @param $applicationName
     * @return ApplicationAbstract|null
     */
    public function getApplication($applicationName): ?ApplicationAbstract
    {
        return $this->_applications[$applicationName] ?? null;
    }

    /**
     * @throws UnitException
     */
    public function removeApplication(ApplicationAbstract $application): bool
    {
        $this->_unitRequest->setMethod(HttpMethodsEnum::DELETE->value);

        $applicationName = $application->getName();
        $this->_unitRequest->send("/config/applications/{$applicationName}");

        return true;
    }

    /**
     * Get routes from config
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->_routes;
    }

    /**
     * Get route from config by name
     *
     * @param string $routeName
     * @return Route|null
     */
    public function getRoute(string $routeName): Route|null
    {
        return $this->_routes[$routeName] ?? null;
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
            $this->_unitRequest->setMethod(HttpMethodsEnum::DELETE->value);
            $this->_unitRequest->send('/config/routes');
        } catch (UnitException $exception) {
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
     * @return mixed|null
     */
    public function getUpstreams(): mixed
    {
        return $this->_upstreams;
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
            $this->_unitRequest->setMethod(HttpMethodsEnum::PUT->value);
            $this->_unitRequest->setData(json_encode($data));
            $this->_unitRequest->send('/config/access_log');
        } catch (UnitException $exception) {
            return false;
        }

        return true;
    }

    public function getAccessLog(): ?AccessLog
    {
        $result = $this->_unitRequest->send('/config/access_log');

        return new AccessLog($result);
    }

    public function removeAccessLog(): bool
    {
        try {
            $this->_unitRequest->setMethod(HttpMethodsEnum::DELETE->value);
            $this->_unitRequest->send('/config/access_log');
        } catch (UnitException $exception) {
            return false;
        }

        return true;
    }

    /**
     * Return config as array
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        foreach (array_keys(get_object_vars($this)) as $key) {
            if (!empty($this->{$key})) {
                $array[substr($key, 1)] = $this->{$key};
            }
        }

        return $array;
    }
}

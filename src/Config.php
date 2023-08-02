<?php

namespace Pavlusha311245\UnitPhpSdk;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Config\AccessLog;
use Pavlusha311245\UnitPhpSdk\Config\Application;
use Pavlusha311245\UnitPhpSdk\Config\Listener;
use Pavlusha311245\UnitPhpSdk\Config\Route;
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
    public function __construct(array $data, private UnitRequest $_unitRequest)
    {
        if (array_key_exists('routes', $data)) {
            foreach ($data['routes'] as $routeName => $routeData) {
                $this->_routes[$routeName] = new Route($routeName, $routeData);
            }
        }

        if (array_key_exists('applications', $data)) {
            foreach ($data['applications'] as $appName => $appData) {
                // TODO: implement go and nodejs detect
                $this->_applications[$appName] = match ($appData['type']) {
                    'php' => new Application\PhpApplication($appData),
                    'external' => new Application\NodeJsApplication($appData),
                };
                $this->_applications[$appName]->setName($appName);
                $this->_applications[$appName]->setUnitRequest($_unitRequest);
            }
        }

        if (array_key_exists('listeners', $data)) {
            foreach ($data['listeners'] as $listener => $listenerData) {
                $listener = (new Listener(
                    _listener: $listener,
                    pass: $listenerData['pass']
                ))->parseFromArray($listenerData);
                $typePath = $listener->getPass()->getPassType();
                $typePathName = $listener->getPass()->toArray()[1];

                ($this->{"_{$typePath}"}[$typePathName])->setListener($listener);

                $this->_listeners[] = $listener;
            }
        }

        if (array_key_exists('upstreams', $data)) {
            $this->_upstreams = $data['upstreams'] ?? [];
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
     * @return mixed
     */
    public function getApplication($applicationName): ApplicationAbstract
    {
        return $this->_applications[$applicationName];
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

        // TODO: need null
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

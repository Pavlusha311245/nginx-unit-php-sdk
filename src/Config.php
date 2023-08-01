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
    public const SOCKET = '/usr/local/var/run/unit/control.sock';
    public const ADDRESS = 'http://localhost';

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
    private array $_upstreams;

    /**
     * Constructor
     *
     * @throws \Exception
     */
    public function __construct(array $data)
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
            }
        }

        if (array_key_exists('listeners', $data)) {
            foreach ($data['listeners'] as $listener => $listenerData) {
                $listener = (new Listener(
                    _listener: $listener
                ))->parseFromArray($listenerData);
                $typePath = $listener->getPass()[0];
                $typePathName = $listener->getPass()[1];

                ($this->{"_{$typePath}"}[$typePathName])->setListener($listener);

                $this->_listeners[] = $listener;
            }
        }

        if (array_key_exists('upstreams', $data)) {
            $this->_upstreams = $data['upstreams'] ?? [];
        }
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
        $request = new UnitRequest(self::SOCKET, self::ADDRESS);
        $request->setMethod(HttpMethodsEnum::DELETE->value);

        $listenerId = $listener->getListener();
        $request->send("/config/listeners/{$listenerId}");

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
        $request = new UnitRequest(self::SOCKET, self::ADDRESS);
        $request->setMethod(HttpMethodsEnum::DELETE->value);

        $applicationName = $application->getName();
        print_r($request->send("/config/applications/{$applicationName}"));

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
            $request = new UnitRequest(self::SOCKET, self::ADDRESS);
            $request->setMethod(HttpMethodsEnum::DELETE->value);
            $request->send('/config/routes');
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
            $request = new UnitRequest(self::SOCKET, self::ADDRESS);
            $request->setMethod(HttpMethodsEnum::PUT->value);
            $request->setData(json_encode($data));
            $request->send('/config/access_log');
        } catch (UnitException $exception) {
            return false;
        }

        return true;
    }

    public function getAccessLog(): ?AccessLog
    {
        $request = new UnitRequest(self::SOCKET, self::ADDRESS);
        $result = $request->send('/config/access_log');

        // TODO: need null
        return new AccessLog($result);
    }

    public function removeAccessLog(): bool
    {
        try {
            $request = new UnitRequest(self::SOCKET, self::ADDRESS);
            $request->setMethod(HttpMethodsEnum::DELETE->value);
            $request->send('/config/access_log');
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

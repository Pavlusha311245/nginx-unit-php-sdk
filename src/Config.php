<?php

namespace Pavlusha311245\UnitPhpSdk;

use Pavlusha311245\UnitPhpSdk\Config\Application;
use Pavlusha311245\UnitPhpSdk\Config\Listener;
use Pavlusha311245\UnitPhpSdk\Config\Route;
use Pavlusha311245\UnitPhpSdk\Interfaces\ConfigInterface;

class Config implements ConfigInterface
{
    private array $_listeners;

    private array $_routes = [];

    private array $_applications = [];

    private array $_upstreams;

    /**
     * Constructor
     *
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        foreach ($data['routes'] as $routeName => $routeData) {
            $this->_routes[$routeName] = new Route($routeName, $routeData);
        }
        foreach ($data['applications'] as $appName => $appData) {
            $this->_applications[$appName] = new Application($appName, $appData);
        }

        foreach ($data['listeners'] as $listener => $listenerData) {
            $listener = (new Listener(
                _listener: $listener
            ))->parseFromArray($listenerData);
            $typePath = $listener->getPass()[0];
            $typePathName = $listener->getPass()[1];

            ($this->{"_{$typePath}"}[$typePathName])->setListener($listener);

            $this->_listeners[] = $listener;
        }

        $this->_upstreams = $data['upstreams'] ?? [];
    }

    /**
     * Get listeners from config
     *
     * @return array
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
    public function getApplication($applicationName)
    {
        return $this->_applications[$applicationName];
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
     * @param $routeName
     * @return mixed
     */
    public function getRoute($routeName)
    {
        return $this->_routes[$routeName];
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
     * Setup access log file path
     *
     * @return void
     */
    public function setApplicationLogPath()
    {
        // TODO: Implement setApplicationLogPath() method.
        // Implement functions from this source https://unit.nginx.org/configuration/#access-log
    }

    /**
     * Setup access log file format
     *
     * @return void
     */
    public function setApplicationLogFormat()
    {
        // TODO: Implement setApplicationLogFormat() method.
        // Implement functions from this source https://unit.nginx.org/configuration/#access-log
    }

    /**
     * Return config as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'listeners' => $this->_listeners,
            'routes' => $this->_routes,
            'applications' => $this->_applications,
            'upstreams' => $this->_upstreams,
        ];
    }
}

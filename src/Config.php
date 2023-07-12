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
                listener: $listener
            ))->parseFromArray($listenerData);

            $typePath = $listener->getPass()[0];
            $typePathName = $listener->getPass()[1];

            ($this->{"_{$typePath}"}[$typePathName])->setListener($listener);

            $this->_listeners[] = $listener;
        }

        $this->_upstreams = $data['upstreams'] ?? [];
    }

    public function getListeners(): array
    {
        return $this->_listeners ?? [];
    }

    public function getApplications(): array
    {
        return $this->_applications;
    }

    public function getApplication($applicationName)
    {
        return $this->_applications[$applicationName];
    }

    public function getRoutes(): array
    {
        return $this->_routes;
    }

    public function getRoute($routeName)
    {
        return $this->_routes[$routeName];
    }

    /**
     * @return mixed|null
     */
    public function getUpstreams(): mixed
    {
        return $this->_upstreams;
    }

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

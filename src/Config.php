<?php

namespace Pavlusha311245\UnitPhpSdk;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Config\Application;
use Pavlusha311245\UnitPhpSdk\Config\Listener;
use Pavlusha311245\UnitPhpSdk\Config\Route;
use Pavlusha311245\UnitPhpSdk\Enums\ApplicationTypeEnum;
use Pavlusha311245\UnitPhpSdk\Interfaces\ConfigInterface;
use PHPUnit\TextUI\Configuration\Php;

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
            // TODO: implement go and nodejs detect
            $this->_applications[$appName] = match ($appData['type']) {
                'php' => new Application\PhpApplication($appData),
                'external' => new Application\NodeJsApplication($appData),
            };
        }

        foreach ($data['listeners'] as $listener => $listenerData) {
            $listener = (new Listener(
                _listener: $listener
            ))->parseFromArray($listenerData);
            $typePath = $listener->getPass()[0];
            $typePathName = $listener->getPass()[1];

//            ($this->{"_{$typePath}"}[$typePathName])->setListener($listener);

            $this->_listeners[] = $listener;
        }

        $this->_upstreams = $data['upstreams'] ?? [];
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
    public function getApplication($applicationName): ApplicationAbstract
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

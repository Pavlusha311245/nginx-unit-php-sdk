<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Config\AccessLog;
use Pavlusha311245\UnitPhpSdk\Config\Listener;
use Pavlusha311245\UnitPhpSdk\Config\Route;

interface ConfigInterface
{
    /**
     * Get all listeners
     *
     * @return array
     */
    public function getListeners(): array;

    /**
     * @param int $port
     * @return Listener|null
     */
    public function getListenerByPort(int $port): Listener|null;

    /**
     * @param Listener $listener
     * @return bool
     */
    public function removeListener(Listener $listener): bool;

    /**
     * @return array
     */
    public function getRoutes(): array;

    /**
     * @param string $routeName
     * @return Route|null
     */
    public function getRoute(string $routeName): Route|null;

    /**
     * Remove all routes and linked listeners
     *
     * @return bool
     */
    public function removeRoutes(): bool;

    /**
     * @param Route|string $route
     * @return bool
     */
    public function removeRoute(Route|string $route): bool;

    /**
     * @return array
     */
    public function getApplications(): array;

    /**
     * @param $applicationName
     * @return ApplicationAbstract|null
     */
    public function getApplication($applicationName): ?ApplicationAbstract;

    /**
     * @param ApplicationAbstract $application
     * @return bool
     */
    public function removeApplication(ApplicationAbstract $application): bool;

    /**
     * @return mixed
     */
    public function getUpstreams();

    /**
     * Setup access log file
     *
     * @param $path
     * @param $format
     * @return mixed
     */
    public function setAccessLog($path, $format = null);

    /**
     * Return access log if exists
     *
     * @return AccessLog|null
     */
    public function getAccessLog(): ?AccessLog;

    /**
     * Remove access log
     *
     * @return bool
     */
    public function removeAccessLog(): bool;

    public function toArray(): array;
}

<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Abstract\ApplicationAbstract;
use UnitPhpSdk\Config\AccessLog;
use UnitPhpSdk\Config\Listener;
use UnitPhpSdk\Config\Route;
use UnitPhpSdk\Config\Upstream;

interface ConfigInterface
{
    /**
     * Get all listeners
     *
     * @return array
     */
    public function getListeners(): array;

    /**
     * TODO: rename to getListenerByPort() and add validation (should be parse)
     *
     * @param int $port
     * @return Listener|null
     */
    public function getListenerByPort(int $port): Listener|null;

    /**
     * Upload Listener object to Nginx Unit server
     *
     * @param Listener $listener
     * @return bool
     */
    public function uploadListener(Listener $listener): bool;

    /**
     * Upload configuration from file
     *
     * @param string $path
     * @param string $listener
     * @return bool
     */
    public function uploadListenerFromFile(string $path, string $listener): bool;

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
     * Upload application to Nginx Unit
     *
     * @param ApplicationAbstract $application
     * @param string $name
     * @return bool
     */
    public function uploadApplication(ApplicationAbstract $application, string $name = ''): bool;

    /**
     * Upload application to Nginx Unit from file
     *
     * @param string $path
     * @param string $name
     * @return mixed
     */
    public function uploadApplicationFromFile(string $path, string $name): bool;

    /**
     * @param ApplicationAbstract|string $application
     * @return bool
     */
    public function removeApplication(ApplicationAbstract|string $application): bool;

    /**
     * Get all upstreams
     *
     * @return mixed
     */
    public function getUpstreams(): array;

    /**
     * Upload Upstream object to nginx Unit
     *
     * @param Upstream $upstream
     * @param string $name
     * @return mixed
     */
    public function uploadUpstream(Upstream $upstream, string $name): bool;

    /**
     * Upload all upstreams from file to Nginx Unit
     *
     * @param string $path
     * @return mixed
     */
    public function uploadUpstreamsFromFile(string $path): bool;

    /**
     * Setup access log file
     *
     * @param $path
     * @param $format
     * @return mixed
     */
    public function setAccessLog($path, $format = null): bool;

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

    /**
     * @return array
     */
    public function toArray(): array;
}

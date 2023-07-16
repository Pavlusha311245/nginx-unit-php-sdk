<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

use Pavlusha311245\UnitPhpSdk\Config\Listener;

interface ConfigInterface
{
    public function getListeners();

    public function getListenerByPort(int $port): Listener|null;

    public function getRoutes();

    public function getRoute($routeName);

    public function getApplications();

    public function getApplication($applicationName);

    public function getUpstreams();

    public function setApplicationLogPath($path);

    public function setApplicationLogFormat($format);

    public function toArray(): array;
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Config\Listener;

interface ConfigInterface
{
    public function getListeners();

    public function getListenerByPort(int $port): Listener|null;

    public function createListener($data);

    public function updateListener($data);

    public function getRoutes(): array;

    public function getRoute($routeName);

    public function createRoute($data);

    public function getApplications(): array;

    public function getApplication($applicationName): ApplicationAbstract;

    public function createApplication($data);

    public function getUpstreams();

    public function toArray(): array;
}

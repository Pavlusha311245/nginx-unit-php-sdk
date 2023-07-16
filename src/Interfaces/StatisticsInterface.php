<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface StatisticsInterface
{
    public function getConnections(): array;

    public function getRequests(): array;

    public function getApplications(): array;
}

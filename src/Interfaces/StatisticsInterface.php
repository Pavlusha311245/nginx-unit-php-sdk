<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface StatisticsInterface
{
    public function getConnections();

    public function getRequests();

    public function getApplications();
}

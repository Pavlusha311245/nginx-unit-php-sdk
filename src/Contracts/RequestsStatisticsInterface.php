<?php

namespace UnitPhpSdk\Contracts;

interface RequestsStatisticsInterface
{
    /**
     * Return total requests statistics
     *
     * @return int
     */
    public function getTotalRequests(): int;
}

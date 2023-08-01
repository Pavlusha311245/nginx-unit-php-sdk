<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface RequestsStatisticsInterface
{
    /**
     * Return all requests statistics
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Return total requests statistics
     *
     * @return int
     */
    public function getTotalRequests(): int;
}

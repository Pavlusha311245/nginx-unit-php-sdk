<?php

namespace UnitPhpSdk\Interfaces;

interface ConnectionsStatisticsInterface
{
    /**
     * Return all connections statistics
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Get count of idle connection
     *
     * @return int
     */
    public function getIdleConnections(): int;

    /**
     * Get count of active connections
     *
     * @return int
     */
    public function getActiveConnections(): int;

    /**
     * Get count of accepted connections
     *
     * @return int
     */
    public function getAcceptedConnections(): int;

    /**
     * Get count of closed connections
     *
     * @return int
     */
    public function getClosedConnections(): int;
}

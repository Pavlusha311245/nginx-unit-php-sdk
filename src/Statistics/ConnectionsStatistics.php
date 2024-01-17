<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\ConnectionsStatisticsInterface;
use UnitPhpSdk\Exceptions\UnitParseException;

/**
 * @readonly ConnectionsStatistics
 * @implements ConnectionsStatisticsInterface, Arrayable
 * @final
 */
final readonly class ConnectionsStatistics implements ConnectionsStatisticsInterface, Arrayable
{
    /**
     * Accepted connections
     *
     * @var int
     */
    private int $accepted;

    /**
     * Active connections
     *
     * @var int
     */
    private int $active;

    /**
     * Idle connections
     *
     * @var int
     */
    private int $idle;

    /**
     * Closed connections
     *
     * @var int
     */
    private int $closed;

    /**
     * @throws UnitParseException
     */
    public function __construct(array $data)
    {
        $this->parseFromArray($data);
    }

    /**
     * @param array $data
     * @return void
     * @throws UnitParseException
     */
    private function parseFromArray(array $data): void
    {
        if (!array_key_exists('idle', $data)
            || !array_key_exists('active', $data)
            || !array_key_exists('accepted', $data)
            || !array_key_exists('closed', $data)) {
            throw new UnitParseException('One or more keys are don\'t exists');
        }

        $this->accepted = $data['accepted'];
        $this->active = $data['active'];
        $this->idle = $data['idle'];
        $this->closed = $data['closed'];
    }

    /**
     * @inheritDoc
     */
    public function getIdleConnections(): int
    {
        return $this->idle;
    }

    /**
     * @inheritDoc
     */
    public function getActiveConnections(): int
    {
        return $this->active;
    }

    /**
     * @inheritDoc
     */
    public function getAcceptedConnections(): int
    {
        return $this->accepted;
    }

    /**
     * @inheritDoc
     */
    public function getClosedConnections(): int
    {
        return $this->closed;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'accepted' => $this->getAcceptedConnections(),
            'active' => $this->getActiveConnections(),
            'idle' => $this->getIdleConnections(),
            'closed' => $this->getClosedConnections(),
        ];
    }
}

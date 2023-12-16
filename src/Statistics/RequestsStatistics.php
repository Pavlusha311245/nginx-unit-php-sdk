<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\RequestsStatisticsInterface;
use UnitPhpSdk\Exceptions\UnitParseException;

/**
 * @readonly RequestsStatistics
 * @implements RequestsStatisticsInterface, Arrayable
 * @final
 */
final readonly class RequestsStatistics implements RequestsStatisticsInterface, Arrayable
{
    /**
     * @throws UnitParseException
     */
    private int $total;

    public function __construct(private array $data)
    {
        if (!array_key_exists('total', $data))
        {
            throw new UnitParseException("Key 'total' not present");
        }

        $this->total = $this->data['total'];
    }

    /**
     * @inheritDoc
     */
    public function getTotalRequests(): int
    {
        return $this->total;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->data;
    }
}

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
        if (!array_key_exists('total', $data)) {
            throw new UnitParseException("Key 'total' not present");
        }

        if (!is_int($data['total'])) {
            throw new UnitParseException("Key 'total' must be integer");
        }

        $this->total = $data['total'];
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
    #[\Override] public function toArray(): array
    {
        return [
            'total' => $this->getTotalRequests()
        ];
    }
}

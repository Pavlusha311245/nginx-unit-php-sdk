<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

/**
 * @readonly Automount
 */
readonly class Automount
{
    public function __construct(private array $data)
    {
        //
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}

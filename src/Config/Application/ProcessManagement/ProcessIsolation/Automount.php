<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

/**
 * @readonly Automount
 */
readonly class Automount
{
    public function __construct(private array $_data)
    {
        //
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

class Automount
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

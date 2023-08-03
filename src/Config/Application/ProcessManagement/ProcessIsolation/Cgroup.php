<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

class Cgroup
{
    public function __construct(private string $_path)
    {
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->_path;
    }
}

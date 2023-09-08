<?php

namespace Pavlusha311245\UnitPhpSdk\Traits;

trait HasTargets
{
    private array $_targets;

    /**
     * @return array
     */
    public function getTargets(): array
    {
        return $this->_targets;
    }

    /**
     * @param array $targets
     */
    public function setTargets(array $targets): void
    {
        $this->_targets = $targets;
    }
}

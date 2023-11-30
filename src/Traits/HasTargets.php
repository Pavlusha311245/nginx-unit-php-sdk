<?php

namespace UnitPhpSdk\Traits;

trait HasTargets
{
    private array $targets = [];

    /**
     * @return array
     */
    public function getTargets(): array
    {
        return $this->targets;
    }

    /**
     * @param array $targets
     */
    public function setTargets(array $targets): void
    {
        $this->targets = $targets;
    }
}

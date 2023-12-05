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
    public function setTargets(array $targets): self
    {
        $this->targets = $targets;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasTargets(): bool
    {
        return !empty($this->targets);
    }
}

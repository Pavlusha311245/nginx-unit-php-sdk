<?php

namespace UnitPhpSdk\Traits;

use UnitPhpSdk\Config\Application\PhpApplication;
use UnitPhpSdk\Config\Application\PythonApplication;

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
     * @return HasTargets|PhpApplication|PythonApplication
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

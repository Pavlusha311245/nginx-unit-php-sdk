<?php

namespace UnitPhpSdk\Contracts;

interface ApplicationControlInterface
{
    /**
     * Restart an application
     *
     * @return bool
     */
    public function restartApplication(): bool;
}

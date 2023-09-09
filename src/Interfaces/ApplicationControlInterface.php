<?php

namespace UnitPhpSdk\Interfaces;

interface ApplicationControlInterface
{
    /**
     * Restart an application
     *
     * @return bool
     */
    public function restartApplication(): bool;
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface ApplicationControlInterface
{
    /**
     * Restart an application
     *
     * @return bool
     */
    public function restartApplication(): bool;
}

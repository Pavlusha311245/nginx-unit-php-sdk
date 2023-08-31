<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface UpstreamInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function getServers(): array;
}

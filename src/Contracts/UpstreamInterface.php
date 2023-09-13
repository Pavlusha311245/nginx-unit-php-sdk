<?php

namespace UnitPhpSdk\Contracts;

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

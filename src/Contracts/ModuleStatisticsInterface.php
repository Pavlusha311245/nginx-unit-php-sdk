<?php

namespace UnitPhpSdk\Contracts;

interface ModuleStatisticsInterface
{
    /**
     * Language module version. If multiple versions are loaded, the list contains multiple items.
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Path to the language module file
     *
     * @return string
     */
    public function getLibPath(): string;
}

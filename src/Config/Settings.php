<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

class Settings
{
    private $_http;
    private string|array $_jsmodules;

    /**
     * @return array|string
     */
    public function getJsmodules(): array|string
    {
        return $this->_jsmodules;
    }

    /**
     * @param array|string $jsmodules
     */
    public function setJsmodules(array|string $jsmodules): void
    {
        $this->_jsmodules = $jsmodules;
    }
}

<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Config\Settings\Http;

class Settings
{
    /**
     * Fine-tunes handling of HTTP requests from the clients
     *
     * @var Http
     */
    private Http $_http;

    /**
     * @var string|array
     */
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

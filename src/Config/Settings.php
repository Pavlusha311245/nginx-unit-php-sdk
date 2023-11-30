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
    private Http $http;

    /**
     * @var string|array
     */
    private string|array $jsmodules;

    /**
     * @return array|string
     */
    public function getJsmodules(): array|string
    {
        return $this->jsmodules;
    }

    /**
     * @param array|string $jsmodules
     */
    public function setJsmodules(array|string $jsmodules): void
    {
        $this->jsmodules = $jsmodules;
    }
}

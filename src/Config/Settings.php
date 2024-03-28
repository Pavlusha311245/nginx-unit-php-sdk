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
    private string|array $js_module;

    public function __construct($data)
    {
        if (array_key_exists('http', $data)) {
            $this->parseHttp($data['http']);
        }

        if (array_key_exists('js_module', $data)) {
            $this->parseJsModule($data['js_module']);
        }
    }

    /**
     * @return Http
     */
    public function getHttp(): Http
    {
        return $this->http;
    }

    private function parseHttp(array $data): void
    {
        $this->http = new Http($data);
    }

    private function parseJsModule(array|string $data): void
    {
        $this->js_module = $data;
    }

    /**
     * @return array|string
     */
    public function getJsModule(): array|string
    {
        return $this->js_module;
    }

    /**
     * @param array|string $js_module
     */
    public function setJsModule(array|string $js_module): void
    {
        $this->js_module = $js_module;
    }
}

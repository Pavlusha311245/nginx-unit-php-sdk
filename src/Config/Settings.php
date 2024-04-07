<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Config\Settings\Http;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Http\UnitRequest;

class Settings implements Uploadable, Arrayable
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

    /**
     * @param UnitRequest $request
     * @return void
     * @throws UnitException
     */
    #[\Override] public function upload(UnitRequest $request)
    {
        $request->setMethod(HttpMethodsEnum::PUT)->send($this->getEndpoint(), $this->toArray());
    }

    /**
     * Removes a record from the server based on the provided request.
     *
     * @param UnitRequest $request The request object containing the necessary information for removal.
     *                            This should be an instance of the UnitRequest class.
     * @return void
     * @throws UnitException Throws an exception if an error occurs during removal.
     */
    #[\Override] public function remove(UnitRequest $request)
    {
        $request->setMethod(HttpMethodsEnum::DELETE)->send($this->getEndpoint());
    }

    private function getEndpoint(): string
    {
        return '/config/settings';
    }

    #[\Override] public function toArray(): array
    {
        return [
            'http' => $this->getHttp()->toArray(),
            'js_module' => $this->getJsModule()
        ];
    }
}

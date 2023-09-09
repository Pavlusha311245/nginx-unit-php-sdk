<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\ApplicationAbstract;
use UnitPhpSdk\Exceptions\UnitException;

class WebAssemblyApplication extends ApplicationAbstract
{
    protected string $_type = 'wasm';

    /**
     * WebAssembly module pathname, including the .wasm extension
     *
     * @var string
     */
    private string $_module = '';

    /**
     * The runtime calls this handler, providing the address of the shared memory block used to pass data in and out the app
     *
     * @var string
     */
    private string $_request_handler = '';

    /**
     * The runtime calls this handler at language module startup to allocate the shared memory block used to pass data in and out the app
     *
     * @var string
     */
    private string $_malloc_handler = '';

    /**
     * The runtime calls this handler at language module shutdown to free the shared memory block used to pass data in and out the app
     *
     * @var string
     */
    private string $_free_handler = '';

    /**
     * @var object|null
     */
    private ?object $_access = null;

    /**
     * It is invoked by the WebAssembly language module at language module startup, after the WebAssembly module was initialised
     *
     * @var string
     */
    private string $_module_init_handler = '';

    /**
     * It is invoked by the WebAssembly language module at language module shutdown
     *
     * @var string
     */
    private string $_module_end_handler = '';

    /**
     * It is invoked by the WebAssembly language module at the start of each request
     *
     * @var string
     */
    private string $_request_init_handler = '';

    /**
     * It is invoked by the WebAssembly language module at the end of each request, when the headers and the request body were received
     *
     * @var string
     */
    private string $_request_end_handler = '';

    /**
     * It is invoked by the WebAssembly language module at the end of each response, when the headers and the response body were sent
     *
     * @var string
     */
    private string $_response_end_handler = '';

    /**
     * @param string $module
     */
    public function setModule(string $module): void
    {
        $this->_module = $module;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->_module;
    }

    /**
     * @param string $request_handler
     */
    public function setRequestHandler(string $request_handler): void
    {
        $this->_request_handler = $request_handler;
    }

    /**
     * @return string
     */
    public function getRequestHandler(): string
    {
        return $this->_request_handler;
    }

    /**
     * @param string $malloc_handler
     */
    public function setMallocHandler(string $malloc_handler): void
    {
        $this->_malloc_handler = $malloc_handler;
    }

    /**
     * @return string
     */
    public function getMallocHandler(): string
    {
        return $this->_malloc_handler;
    }

    /**
     * @param string $free_handler
     */
    public function setFreeHandler(string $free_handler): void
    {
        $this->_free_handler = $free_handler;
    }

    /**
     * @return string
     */
    public function getFreeHandler(): string
    {
        return $this->_free_handler;
    }

    /**
     * @param object $access
     */
    public function setAccess(object $access): void
    {
        $this->_access = $access;
    }

    /**
     * @return object
     */
    public function getAccess(): object
    {
        return $this->_access;
    }

    /**
     * @param string $module_init_handler
     */
    public function setModuleInitHandler(string $module_init_handler): void
    {
        $this->_module_init_handler = $module_init_handler;
    }

    /**
     * @return string
     */
    public function getModuleEndHandler(): string
    {
        return $this->_module_end_handler;
    }

    /**
     * @param string $module_end_handler
     */
    public function setModuleEndHandler(string $module_end_handler): void
    {
        $this->_module_end_handler = $module_end_handler;
    }

    /**
     * @return string
     */
    public function getModuleInitHandler(): string
    {
        return $this->_module_init_handler;
    }

    /**
     * @param string $request_init_handler
     */
    public function setRequestInitHandler(string $request_init_handler): void
    {
        $this->_request_init_handler = $request_init_handler;
    }

    /**
     * @return string
     */
    public function getRequestInitHandler(): string
    {
        return $this->_request_init_handler;
    }


    /**
     * @param string $request_end_handler
     */
    public function setRequestEndHandler(string $request_end_handler): void
    {
        $this->_request_end_handler = $request_end_handler;
    }

    /**
     * @return string
     */
    public function getRequestEndHandler(): string
    {
        return $this->_request_end_handler;
    }

    /**
     * @param string $response_end_handler
     */
    public function setResponseEndHandler(string $response_end_handler): void
    {
        $this->_response_end_handler = $response_end_handler;
    }

    /**
     * @return string
     */
    public function getResponseEndHandler(): string
    {
        return $this->_response_end_handler;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('module', $data)) {
            throw new UnitException('Module key is required');
        }

        if (!array_key_exists('request_handler', $data)) {
            throw new UnitException('Request handler key is required');
        }

        if (!array_key_exists('malloc_handler', $data)) {
            throw new UnitException('Malloc handler key is required');
        }

        if (!array_key_exists('free_handler', $data)) {
            throw new UnitException('Free handler key is required');
        }

        $this->setModule($data['module']);
        $this->setRequestHandler($data['request_handler']);
        $this->setMallocHandler($data['malloc_handler']);
        $this->setFreeHandler($data['free_handler']);

        if (array_key_exists('access', $data)) {
            $this->setAccess($data['access']);
        }

        if (array_key_exists('module_init_handler', $data)) {
            $this->setModuleInitHandler($data['module_init_handler']);
        }

        if (array_key_exists('module_end_handler', $data)) {
            $this->setModuleEndHandler($data['module_end_handler']);
        }

        if (array_key_exists('request_init_handler', $data)) {
            $this->setRequestInitHandler($data['request_init_handler']);
        }

        if (array_key_exists('request_end_handler', $data)) {
            $this->setRequestEndHandler($data['request_end_handler']);
        }

        if (array_key_exists('response_end_handler', $data)) {
            $this->setRequestEndHandler($data['response_end_handler']);
        }
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'module' => $this->getModule(),
                'request_handler' => $this->getRequestHandler(),
                'malloc_handler' => $this->getMallocHandler(),
                'free_handler' => $this->getFreeHandler(),
                'module_init_handler' => $this->getModuleInitHandler(),
                'module_end_handler' => $this->getModuleEndHandler(),
                'request_init_handler' => $this->getRequestInitHandler(),
                'request_end_handler' => $this->getRequestEndHandler(),
                'response_end_handler' => $this->getResponseEndHandler(),
            ]
        );
    }
}

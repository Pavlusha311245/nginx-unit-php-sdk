<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Exceptions\RequiredKeyException;

/**
 * @extends AbstractApplication
 */
class WebAssemblyApplication extends AbstractApplication
{
    public const array REQUIRED_KEYS = ['module', 'request_handler', 'malloc_handler', 'free_handler'];

    public const array OPTIONAL_KEYS = [
        'access',
        'module_init_handler',
        'module_end_handler',
        'request_init_handler',
        'request_end_handler',
        'response_end_handler'
    ];

    public const array ALL_KEYS = self::REQUIRED_KEYS + self::OPTIONAL_KEYS;

    public const string TYPE = 'wasm';

    /**
     * WebAssembly module pathname, including the .wasm extension
     *
     * @var string
     */
    private string $module = '';

    /**
     * The runtime calls this handler, providing the address of the shared memory block used to pass data in and out the app
     *
     * @var string
     */
    private string $request_handler = '';

    /**
     * The runtime calls this handler at language module startup to allocate the shared memory block used to pass data in and out the app
     *
     * @var string
     */
    private string $malloc_handler = '';

    /**
     * The runtime calls this handler at language module shutdown to free the shared memory block used to pass data in and out the app
     *
     * @var string
     */
    private string $free_handler = '';

    /**
     * @var object|null
     */
    private ?object $access = null;

    /**
     * It is invoked by the WebAssembly language module at language module startup, after the WebAssembly module was initialised
     *
     * @var string
     */
    private string $module_init_handler = '';

    /**
     * It is invoked by the WebAssembly language module at language module shutdown
     *
     * @var string
     */
    private string $module_end_handler = '';

    /**
     * It is invoked by the WebAssembly language module at the start of each request
     *
     * @var string
     */
    private string $request_init_handler = '';

    /**
     * It is invoked by the WebAssembly language module at the end of each request, when the headers and the request body were received
     *
     * @var string
     */
    private string $request_end_handler = '';

    /**
     * It is invoked by the WebAssembly language module at the end of each response, when the headers and the response body were sent
     *
     * @var string
     */
    private string $response_end_handler = '';

    /**
     * @return array
     */
    public function getRequiredKeys(): array
    {
        return self::REQUIRED_KEYS;
    }

    /**
     * @param string $module
     * @return WebAssemblyApplication
     */
    public function setModule(string $module): self
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @param string $request_handler
     * @return WebAssemblyApplication
     */
    public function setRequestHandler(string $request_handler): self
    {
        $this->request_handler = $request_handler;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestHandler(): string
    {
        return $this->request_handler;
    }

    /**
     * @param string $malloc_handler
     * @return WebAssemblyApplication
     */
    public function setMallocHandler(string $malloc_handler): self
    {
        $this->malloc_handler = $malloc_handler;

        return $this;
    }

    /**
     * @return string
     */
    public function getMallocHandler(): string
    {
        return $this->malloc_handler;
    }

    /**
     * @param string $free_handler
     * @return WebAssemblyApplication
     */
    public function setFreeHandler(string $free_handler): self
    {
        $this->free_handler = $free_handler;

        return $this;
    }

    /**
     * @return string
     */
    public function getFreeHandler(): string
    {
        return $this->free_handler;
    }

    /**
     * @param object $access
     * @return WebAssemblyApplication
     */
    public function setAccess(object $access): self
    {
        $this->access = $access;

        return $this;
    }

    /**
     * @return object
     */
    public function getAccess(): object
    {
        return $this->access;
    }

    /**
     * @param string $module_init_handler
     * @return WebAssemblyApplication
     */
    public function setModuleInitHandler(string $module_init_handler): self
    {
        $this->module_init_handler = $module_init_handler;

        return $this;
    }

    /**
     * @return string
     */
    public function getModuleEndHandler(): string
    {
        return $this->module_end_handler;
    }

    /**
     * @param string $module_end_handler
     * @return WebAssemblyApplication
     */
    public function setModuleEndHandler(string $module_end_handler): self
    {
        $this->module_end_handler = $module_end_handler;

        return $this;
    }

    /**
     * @return string
     */
    public function getModuleInitHandler(): string
    {
        return $this->module_init_handler;
    }

    /**
     * @param string $request_init_handler
     * @return WebAssemblyApplication
     */
    public function setRequestInitHandler(string $request_init_handler): self
    {
        $this->request_init_handler = $request_init_handler;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestInitHandler(): string
    {
        return $this->request_init_handler;
    }


    /**
     * @param string $request_end_handler
     * @return WebAssemblyApplication
     */
    public function setRequestEndHandler(string $request_end_handler): self
    {
        $this->request_end_handler = $request_end_handler;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestEndHandler(): string
    {
        return $this->request_end_handler;
    }

    /**
     * @param string $response_end_handler
     * @return WebAssemblyApplication
     */
    public function setResponseEndHandler(string $response_end_handler): self
    {
        $this->response_end_handler = $response_end_handler;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseEndHandler(): string
    {
        return $this->response_end_handler;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        $data = array_filter($data, fn ($value) => !empty($value));

        foreach (self::REQUIRED_KEYS as $key) {
            if (!array_key_exists($key, $data)) {
                throw new RequiredKeyException($key);
            }
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

    /**
     * @inheritDoc
     */
    #[\Override] public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'type' => self::TYPE,
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

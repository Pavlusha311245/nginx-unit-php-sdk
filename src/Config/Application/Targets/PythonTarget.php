<?php

namespace UnitPhpSdk\Config\Application\Targets;

use UnitPhpSdk\Exceptions\RequiredKeyException;

class PythonTarget
{
    /**
     * App’s module nam
     *
     * @var string
     */
    private string $module;

    /**
     * Name of the module-based callable that Unit runs as the app.
     *
     * @var string
     */
    private string $callable = 'application';

    /**
     * @throws RequiredKeyException
     */
    public function __construct(array $data)
    {
        if (!array_key_exists('module', $data)) {
            throw new RequiredKeyException('module');
        }

        $this->setModule($data['module']);

        if (array_key_exists('callable', $data)) {
            $this->setCallable($data['callable']);
        }
    }

    /**
     * @param string $module
     */
    public function setModule(string $module): void
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @param string $callable
     */
    public function setCallable(string $callable): void
    {
        $this->callable = $callable;
    }

    /**
     * @return string
     */
    public function getCallable(): string
    {
        return $this->callable;
    }
}

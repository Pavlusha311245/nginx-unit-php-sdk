<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Config\Application\Targets\PythonTarget;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Traits\HasTargets;
use UnitPhpSdk\Traits\HasThreads;
use UnitPhpSdk\Traits\HasThreadStackSize;

/**
 * @extends AbstractApplication
 */
class PythonApplication extends AbstractApplication
{
    use HasThreads;
    use HasThreadStackSize;
    use HasTargets;

    protected string $_type = 'python';

    /**
     * app’s module name
     *
     * @var string
     */
    private string $_module;

    /**
     * Name of the module-based callable that Unit runs as the app.
     *
     * @var string
     */
    private string $_callable = 'application';
    private string $_home = '';

    /**
     * Additional Python module lookup paths
     *
     * @var string|array
     */
    private string|array $_path = '';
    private string $_prefix = '';
    private string $_protocol = '';

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
     * @param string $callable
     */
    public function setCallable(string $callable): void
    {
        $this->_callable = $callable;
    }

    /**
     * @return string
     */
    public function getCallable(): string
    {
        return $this->_callable;
    }

    /**
     * @param string $home
     */
    public function setHome(string $home): void
    {
        $this->_home = $home;
    }

    /**
     * @return string
     */
    public function getHome(): string
    {
        return $this->_home;
    }

    /**
     * @param array|string $path
     */
    public function setPath(array|string $path): void
    {
        $this->_path = $path;
    }

    /**
     * @return array|string
     */
    public function getPath(): array|string
    {
        return $this->_path;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix): void
    {
        $this->_prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->_prefix;
    }

    /**
     * @param string $protocol
     */
    public function setProtocol(string $protocol): void
    {
        $this->_protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->_protocol;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('module', $data) && !array_key_exists('targets', $data)) {
            throw new RequiredKeyException('module', 'targets');
        }

        if (array_key_exists('module', $data)) {
            $this->setModule($data['module']);
        }

        if (array_key_exists('targets', $data)) {
            $targets = [];

            foreach ($data['targets'] as $targetName => $targetValues) {
                $targets[$targetName] = new PythonTarget($targetValues);
            }

            $this->setTargets($targets);
        }

        if (array_key_exists('callable', $data)) {
            $this->setCallable($data['callable']);
        }

        if (array_key_exists('home', $data)) {
            $this->setHome($data['home']);
        }

        if (array_key_exists('path', $data)) {
            $this->setPath($data['path']);
        }

        if (array_key_exists('prefix', $data)) {
            $this->setPrefix($data['prefix']);
        }

        if (array_key_exists('protocol', $data)) {
            $this->setProtocol($data['protocol']);
        }

        if (array_key_exists('thread_stack_size', $data)) {
            $this->setThreadStackSize($data['thread_stack_size']);
        }

        if (array_key_exists('threads', $data)) {
            $this->setThreads($data['threads']);
        }
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'callable' => $this->getCallable(),
                'home' => $this->getHome(),
                'path' => $this->getPath(),
                'prefix' => $this->getPrefix(),
                'protocol' => $this->getProtocol(),
                'targets' => $this->getTargets(),
                'thread_stack_size' => $this->getThreadStackSize(),
                'threads' => $this->getThreads(),
            ]
        );
    }
}

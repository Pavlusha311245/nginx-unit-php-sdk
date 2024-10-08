<?php

namespace UnitPhpSdk\Config\Application;

use InvalidArgumentException;
use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Config\Application\Targets\PythonTarget;
use UnitPhpSdk\Exceptions\RequiredKeyException;
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

    public const array REQUIRED_KEYS = ['module'];

    public const array OPTIONAL_KEYS = [
        'callable',
        'home',
        'path',
        'prefix',
        'protocol',
        'targets',
        'thread_stack_size',
        'threads',
    ];

    public const array ALL_KEYS = self::REQUIRED_KEYS + self::OPTIONAL_KEYS;

    public const string TYPE = 'python';

    /**
     * App’s module name
     *
     * @var string
     */
    private string $module = '';

    /**
     * Name of the module-based callable that Unit runs as the app.
     *
     * @var string
     */
    private string $callable = 'application';

    /**
     * The path to the Python virtual environment directory.
     *
     * @var string
     */
    private string $home = '';

    /**
     * Additional Python module lookup paths
     *
     * @var string|array
     */
    private string|array $path = '';

    /**
     * @var string
     */
    private string $prefix = '';

    /**
     * @var string
     */
    private string $protocol = '';

    /**
     * @return array|string[]
     */
    public function getRequiredKeys(): array
    {
        return self::REQUIRED_KEYS;
    }

    /**
     * @param string $module
     * @return $this
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
     * @param string $callable
     * @return PythonApplication
     */
    public function setCallable(string $callable): self
    {
        $this->callable = $callable;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallable(): string
    {
        return $this->callable;
    }

    /**
     * @param string $home
     * @return PythonApplication
     */
    public function setHome(string $home): self
    {
        $this->home = $home;

        return $this;
    }

    /**
     * @return string
     */
    public function getHome(): string
    {
        return $this->home;
    }

    /**
     * @param array|string $path
     * @return PythonApplication
     */
    public function setPath(array|string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getPath(): array|string
    {
        return $this->path;
    }

    /**
     * @param string $prefix
     * @return PythonApplication
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $protocol
     * @return PythonApplication
     */
    public function setProtocol(string $protocol): self
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        $data = array_filter($data, fn ($value) => !empty($value));

        if (!array_key_exists('module', $data) && !array_key_exists('targets', $data)) {
            throw new RequiredKeyException('module', 'targets');
        }

        if (array_key_exists('module', $data)) {
            $this->setModule($data['module']);
        }

        // TODO: add condition to skip this step if module does not exist
        if (array_key_exists('targets', $data) && !empty($data['targets'])) {
            $targets = [];

            foreach ($data['targets'] as $targetName => $targetValues) {
                if (!is_array($targetValues) && !is_a(PythonTarget::class, $targetValues)) {
                    throw new InvalidArgumentException('targets must be an array or an instance of PythonTarget');
                }

                $targets[$targetName] = is_array($targetValues) ? new PythonTarget($targetValues) : $targetValues;
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

    /**
     * @inheritDoc
     */
    #[\Override] public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'type' => self::TYPE,
                'callable' => $this->getCallable(),
                'home' => $this->getHome(),
                'path' => $this->getPath(),
                'prefix' => $this->getPrefix(),
                'protocol' => $this->getProtocol(),
                'targets' =>  array_map(fn (PythonTarget $target) => $target->toArray(), $this->getTargets() ?? []),
                'thread_stack_size' => $this->getThreadStackSize(),
                'threads' => $this->getThreads(),
                'module' => $this->getModule(),
            ]
        );
    }
}

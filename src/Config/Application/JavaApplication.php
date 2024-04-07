<?php

namespace UnitPhpSdk\Config\Application;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Traits\HasThreads;
use UnitPhpSdk\Traits\HasThreadStackSize;

/**
 * @extends AbstractApplication
 */
class JavaApplication extends AbstractApplication
{
    use HasThreads;
    use HasThreadStackSize;

    public const array REQUIRED_KEYS = ['webapp'];

    public const array OPTIONAL_KEYS = ['options', 'classpath'];

    public const array ALL_KEYS = self::REQUIRED_KEYS + self::OPTIONAL_KEYS;

    public const string TYPE = 'java';

    /**
     * Pathname of the application’s .war file (packaged or unpackaged)
     *
     * @var string
     */
    private string $webApp;

    /**
     * Defines JVM runtime options
     *
     * @var array
     */
    private array $options = [];

    /**
     * Paths to your app’s required libraries (may point to directories or individual .jar files).
     *
     * @var array
     */
    private array $classPath = [];

    /**
     * @return array|string[]
     */
    public function getRequiredKeys(): array
    {
        return self::REQUIRED_KEYS;
    }

    /**
     * @return string
     */
    public function getWebApp(): string
    {
        return $this->webApp;
    }

    /**
     * @param string $webApp
     * @return JavaApplication
     */
    public function setWebApp(string $webApp): self
    {
        $this->webApp = $webApp;

        return $this;
    }

    /**
     * @param array $classPath
     * @return JavaApplication
     */
    public function setClassPath(array $classPath): self
    {
        $this->classPath = $classPath;

        return $this;
    }

    /**
     * @return array
     */
    public function getClassPath(): array
    {
        return $this->classPath;
    }

    /**
     * @param array $options
     * @return JavaApplication
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('webapp', $data)) {
            throw new RequiredKeyException('webapp');
        }

        $this->setWebApp($data['webapp']);

        if (array_key_exists('options', $data)) {
            $this->setOptions($data['options']);
        }

        if (array_key_exists('classpath', $data)) {
            $this->setClassPath($data['classpath']);
        }

        if (array_key_exists('thread_stack_size', $data)) {
            $this->setThreadStackSize($data['thread_stack_size']);
        }

        if (array_key_exists('threads', $data)) {
            $this->setThreads($data['threads']);
        }
    }

    #[\Override] public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'type' => self::TYPE,
                'webapp' => $this->getWebApp(),
                'options' => $this->getOptions(),
                'classpath' => $this->getClassPath(),
                'thread_stack_size' => $this->getThreadStackSize(),
                'threads' => $this->getThreads(),
            ]
        );
    }
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;
use Pavlusha311245\UnitPhpSdk\Traits\HasThreads;
use Pavlusha311245\UnitPhpSdk\Traits\HasThreadStackSize;

class JavaApplication extends ApplicationAbstract
{
    use HasThreads;
    use HasThreadStackSize;

    protected string $_type = 'java';

    /**
     * Pathname of the application’s .war file (packaged or unpackaged)
     *
     * @var string
     */
    private string $_webApp;

    /**
     * Defines JVM runtime options
     *
     * @var array
     */
    private array $_options = [];

    /**
     * Paths to your app’s required libraries (may point to directories or individual .jar files).
     *
     * @var array
     */
    private array $_classPath = [];

    /**
     * @return string
     */
    public function getWebApp(): string
    {
        return $this->_webApp;
    }

    /**
     * @param string $webApp
     */
    public function setWebApp(string $webApp): void
    {
        $this->_webApp = $webApp;
    }

    /**
     * @param array $classPath
     */
    public function setClassPath(array $classPath): void
    {
        $this->_classPath = $classPath;
    }

    /**
     * @return array
     */
    public function getClassPath(): array
    {
        return $this->_classPath;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->_options = $options;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->_options;
    }

    /**
     * @inheritDoc
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('webapp', $data)) {
            throw new UnitException('Webapp key is required');
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
}

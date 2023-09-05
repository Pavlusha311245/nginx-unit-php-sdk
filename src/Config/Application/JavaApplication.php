<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;

class JavaApplication extends ApplicationAbstract
{
    protected string $_type = 'java';

    /**
     * Pathname of the application’s .war file (packaged or unpackaged)
     *
     * @var string
     */
    private string $_webApp;

    /**
     * Paths to your app’s required libraries (may point to directories or individual .jar files).
     *
     * @var array|string
     */
    private array|string $_classPath;

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
     * @return array|string
     */
    public function getClassPath(): array|string
    {
        return $this->_classPath;
    }

    /**
     * @param array|string $classPath
     */
    public function setClassPath(array|string $classPath): void
    {
        $this->_classPath = $classPath;
    }
}

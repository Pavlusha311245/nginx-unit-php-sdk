<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;

class NodeJsApplication extends ApplicationAbstract
{
    protected string $_type = 'external';

    /**
     * Pathname of the app, absolute or relative to working_directory
     *
     * @var string
     */
    private string $_executable;

    /**
     * Command-line arguments to be passed to the app
     *
     * @var array|string
     */
    private array|string $_arguments;

    /**
     * @return string
     */
    public function getExecutable(): string
    {
        return $this->_executable;
    }

    /**
     * @param string $executable
     */
    public function setExecutable(string $executable): void
    {
        $this->_executable = $executable;
    }

    /**
     * @return array|string
     */
    public function getArguments(): array|string
    {
        return $this->_arguments;
    }

    /**
     * @param array|string $arguments
     */
    public function setArguments(array|string $arguments): void
    {
        $this->_arguments = $arguments;
    }

    public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (array_key_exists('arguments', $data)) {
            $this->setArguments($data['arguments']);
        }

        if (array_key_exists('executable', $data)) {
            $this->setExecutable($data['executable']);
        }
    }
}

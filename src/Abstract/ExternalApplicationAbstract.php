<?php

namespace Pavlusha311245\UnitPhpSdk\Abstract;

use Pavlusha311245\UnitPhpSdk\Abstract\ApplicationAbstract;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;

class ExternalApplicationAbstract extends ApplicationAbstract
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
    private array|string $_arguments = [];

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

    public final function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('executable', $data)) {
            throw new UnitException('Executable key is required');
        }

        $this->setExecutable($data['executable']);

        if (array_key_exists('arguments', $data)) {
            $this->setArguments($data['arguments']);
        }
    }
}

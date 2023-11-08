<?php

namespace UnitPhpSdk\Abstract;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Exceptions\UnitException;

/**
 * @extends  AbstractApplication
 */
class AbstractExternalApplication extends AbstractApplication
{
    public const TYPE = 'external';

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

    /**
     * Parse data from array
     *
     * @param array $data
     * @return void
     * @throws RequiredKeyException
     * @throws UnitException
     */
    final public function parseFromArray(array $data): void
    {
        parent::parseFromArray($data);

        if (!array_key_exists('executable', $data)) {
            throw new RequiredKeyException('executable');
        }

        $this->setExecutable($data['executable']);

        if (array_key_exists('arguments', $data)) {
            $this->setArguments($data['arguments']);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'executable' => $this->getExecutable(),
                'arguments' => $this->getArguments()
            ]
        );
    }
}

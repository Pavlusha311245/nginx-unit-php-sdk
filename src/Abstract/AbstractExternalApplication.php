<?php

namespace UnitPhpSdk\Abstract;

use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Exceptions\UnitException;

/**
 * @extends  AbstractApplication
 */
class AbstractExternalApplication extends AbstractApplication
{
    public const string TYPE = 'external';

    /**
     * Pathname of the app, absolute or relative to working_directory
     *
     * @var string
     */
    private string $executable;

    /**
     * Command-line arguments to be passed to the app
     *
     * @var array|string
     */
    private array|string $arguments = [];

    /**
     * @return string
     */
    public function getExecutable(): string
    {
        return $this->executable;
    }

    /**
     * @param string $executable
     * @return AbstractExternalApplication
     */
    public function setExecutable(string $executable): self
    {
        $this->executable = $executable;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getArguments(): array|string
    {
        return $this->arguments;
    }

    /**
     * @param array|string $arguments
     * @return AbstractExternalApplication
     */
    public function setArguments(array|string $arguments): self
    {
        $this->arguments = $arguments;

        return $this;
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
     * @inheritDoc
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

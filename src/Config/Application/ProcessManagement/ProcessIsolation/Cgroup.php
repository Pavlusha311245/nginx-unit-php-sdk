<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Exceptions\UnitException;

class Cgroup implements Arrayable
{
    private string $path;

    public function __construct(array $data)
    {
        if (!array_key_exists('path', $data)) {
            throw new UnitException('Cgroup path not found');
        }

        $this->setPath($data['path']);
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function toArray(): array
    {
        return [
            'path' => $this->getPath()
        ];
    }
}

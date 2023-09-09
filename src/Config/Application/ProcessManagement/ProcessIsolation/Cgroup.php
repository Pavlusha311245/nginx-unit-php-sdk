<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

use UnitPhpSdk\Exceptions\UnitException;

readonly class Cgroup
{
    private string $_path;

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
        $this->_path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->_path;
    }

    public function toArray()
    {
        return [
            'path' => $this->getPath()
        ];
    }
}

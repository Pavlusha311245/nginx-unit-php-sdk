<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

class AccessLog
{
    private ?string $_path;
    private ?string $_format;

    public function __construct(
        array $data
    ) {
        $this->_path = $data['path'] ?? null;
        $this->_format = $data['format'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->_path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->_path = $path;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->_format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->_format = $format;
    }
}

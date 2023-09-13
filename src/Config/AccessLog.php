<?php

namespace UnitPhpSdk\Config;

class AccessLog
{
    /**
     * Pathname of the access log file.
     *
     * @var string|mixed|null
     */
    private ?string $_path;

    /**
     * Log format. Besides arbitrary text, can contain any variables Unit supports
     *
     * @var string|mixed|null
     */
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

<?php

namespace UnitPhpSdk\Config;

class AccessLog
{
    /**
     * Pathname of the access log file.
     *
     * @var string|mixed|null
     */
    private ?string $path;

    /**
     * Log format. Besides arbitrary text, can contain any variables Unit supports
     *
     * @var string|mixed|null
     */
    private ?string $format;

    public function __construct(
        array $data
    )
    {
        $this->path = $data['path'] ?? null;
        $this->format = $data['format'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }
}

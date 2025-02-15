<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Builders\EndpointBuilder;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Enums\ApiPathEnum;
use UnitPhpSdk\Traits\CanUpload;

class AccessLog implements Uploadable, Arrayable
{
    use CanUpload;

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
    private string|array|null $format;

    public function __construct(
        array $data
    ) {
        $this->path = $data['path'] ?? null;
        $this->format = $data['format'] ?? null;

        $this->setApiEndpoint(ApiPathEnum::ACCESS_LOG->value);
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

    /**
     * @inheritDoc
     */
    #[\Override] public function toArray(): array
    {
        return [
            'path' => $this->path,
            'format' => $this->format,
        ];
    }
}

<?php

namespace UnitPhpSdk\Config;

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

    /**
     * The access_log can be dynamically turned on and off by using the if option
     *
     * This feature lets users set conditions to determine whether access logs are recorded.
     * The if option supports a string and JavaScript code.
     * If its value is empty, 0, false, null, or undefined,
     * the logs will not be recorded. And the ‘!’ as a prefix inverses the condition.
     *
     * @var string|mixed|null
     */
    private ?string $if;

    public function __construct(
        array $data
    )
    {
        $this->path = $data['path'] ?? null;
        $this->format = $data['format'] ?? null;
        $this->if = $data['if'] ?? null;

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
     * @return string|array|null
     */
    public function getFormat(): string|array|null
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
            'if' => $this->if,
            'path' => $this->path,
            'format' => $this->format,
        ];
    }

    public function getIf(): ?string
    {
        return $this->if;
    }

    public function setIf(?string $if): void
    {
        $this->if = $if;
    }

}

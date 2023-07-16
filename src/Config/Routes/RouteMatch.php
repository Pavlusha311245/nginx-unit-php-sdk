<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Routes;

use Pavlusha311245\UnitPhpSdk\Enums\HttpSchemeEnum;

class RouteMatch
{
    private string $_host;

    private string|null $_method;

    private string|null $_source;

    private string|null $_destination;

    private HttpSchemeEnum|null $_scheme;

    private array|string|null $_uri;

    public function __construct($data)
    {
        $this->_uri = $data['uri'] ?? null;
        $this->_scheme = $data['scheme'] ?? null;
        $this->_method = $data['method'] ?? null;
    }

    /**
     * Get method
     *
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->_method;
    }

    /**
     * Get uri
     *
     * @return array|string|null
     */
    public function getUri(): array|string|null
    {
        return $this->_uri;
    }

    /**
     * Get http scheme
     *
     * @return HttpSchemeEnum|null
     */
    public function getScheme(): ?HttpSchemeEnum
    {
        return $this->_scheme;
    }

    /**
     * Set HTTP scheme
     *
     * @param string $scheme
     * @return void
     */
    public function setScheme(string $scheme): void
    {
        $this->_scheme = match ($scheme) {
            'http' => HttpSchemeEnum::HTTP,
            'https' => HttpSchemeEnum::HTTPS,
            default => null
        };
    }
}

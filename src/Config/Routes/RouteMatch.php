<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Routes;

class RouteMatch
{
    private string $_host;

    private string $_method;

    private string $_source;

    private string $_destination;

    private string $_scheme;

    private array|string $_uri;

    public function setScheme(string $scheme): void
    {
        $this->_scheme = match ($scheme) {
            'http' || 'https' => $scheme,
            default => null
        };
    }
}

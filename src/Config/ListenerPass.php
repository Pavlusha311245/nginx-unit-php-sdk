<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

readonly class ListenerPass
{
    /**
     * @var string
     */
    private string $_passType;

    public function __construct(private string $_data)
    {
        $this->_passType = explode('/', $_data)[0];
    }

    /**
     * Return pass type (application, routes, route, upstreams)
     *
     * @return string
     */
    public function getPassType(): string
    {
        return $this->_passType;
    }

    /**
     * Return pass as string
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->_data;
    }

    /**
     * Return pass as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return explode('/', $this->_data);
    }
}

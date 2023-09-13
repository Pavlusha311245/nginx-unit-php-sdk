<?php

namespace UnitPhpSdk\Config\Listener;

readonly class ListenerPass
{
    /**
     * @var string
     */
    private string $_type;

    public function __construct(private string $_data)
    {
        $this->_type = explode('/', $_data)[0];
    }


    /**
     * Return pass type (application, routes, route, upstreams)
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->_type;
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

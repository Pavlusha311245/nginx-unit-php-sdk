<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Routes;

class RouteBlock
{
    private $_action;

    private $_match;

    public function __construct(array $data)
    {
        $this->_action = $data['action'];
        $this->_match = $data['match'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getMatch(): mixed
    {
        return $this->_match;
    }

    public function getAction(): mixed
    {
        return $this->_action;
    }
}

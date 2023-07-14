<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Routes;

class RouteBlock
{
    private RouteAction $_action;

    private $_match;

    public function __construct(array $data)
    {
//        $this->_action = $data['action'];
//        $this->_match = $data['match'] ?? null;

        $this->_action = new RouteAction($data['action']);
        if (isset($data['match']))
        {
            $this->_match = new RouteMatch($data['match']);
        }
    }

    /**
     * Get match
     *
     * @return RouteMatch
     */
    public function getMatch()
    {
        return $this->_match;
    }

    /**
     * Get action
     *
     * @return mixed
     */
    public function getAction(): mixed
    {
        return $this->_action;
    }
}

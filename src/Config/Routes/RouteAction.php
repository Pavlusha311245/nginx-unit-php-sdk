<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Routes;

class RouteAction
{
    private string $_pass;
    private string $_proxy;
    private int $_return;
    private string $_location;
    private array|string $_share;
    private string $_rewrite;

    public function __construct($data)
    {
        $this->_share = $data['share'] ?? null;
    }

    /**
     * Receive return key
     *
     * @return mixed
     */
    public function getReturn()
    {
        return $this->_return;
    }

    /**
     * Set return key
     *
     * @param mixed $return
     */
    public function setReturn(int $return): void
    {
        if ($return > 999 && $return < 0) {
            throw new \OutOfRangeException();
        }

        $this->_return = $return;
    }
}

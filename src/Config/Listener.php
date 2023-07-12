<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

class Listener
{
    private $_link;
    private array $_pass = [];
    private string $_listener;
    private $_port;

    public function __construct(
        string        $listener,
        string        $pass = '',
        private array $_tls = [],
        private array $_forwarded = [],
    )
    {
        $this->_listener = $listener;
        $this->_port = explode(':', $listener)[1];
        if (!empty($pass)) {
            $this->_pass = explode('/', $pass);
        }
    }

    public function getForwarded(): array
    {
        return $this->_forwarded;
    }

    public function getPass(): array
    {
        return $this->_pass;
    }

    public function getTls(): array
    {
        return $this->_tls;
    }

    /**
     * @return mixed
     */
    public function getListener()
    {
        return $this->_listener;
    }

    /**
     * Parse data from array
     *
     * @throws \Exception
     */
    public function parseFromArray(array $data): Listener
    {
        if (!array_key_exists('pass', $data)) {
            throw new \Exception("Missing required 'pass' array key");
        }

        $this->_pass = explode('/', $data['pass']);
        $this->_forwarded = $data['forwarded'] ?? [];
        $this->_tls = $data['tls'] ?? [];

        return $this;
    }
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;

/**
 * This class presents "listeners" section from config
 */
class Listener
{
    private string $_link;
    private array $_pass = [];
    private int $_port;

    public function __construct(
        private string $_listener,
        string         $pass = '',
        private array  $_tls = [],
        private array  $_forwarded = [],
    )
    {
        $this->parsePort();
        $this->generateLink();

        if (!empty($pass)) {
            $this->_pass = explode('/', $pass);
        }
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink(): string
    {
        return $this->_link;
    }

    /**
     * Generate link from listener
     *
     * @return void
     */
    private function generateLink()
    {
        $separatedListener = explode(':', $this->_listener);

        $this->_link = $separatedListener[0] == '*' ?
            "0.0.0.0:{$separatedListener[1]}" : $separatedListener;
    }

    /**
     * Parse port
     *
     * @return void
     */
    private function parsePort(): void
    {
        $this->_port = explode(':', $this->_listener)[1];
    }

    /**
     * Get port
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->_port;
    }

    /**
     * Get forwarded
     *
     * @return array
     */
    public function getForwarded(): array
    {
        return $this->_forwarded;
    }

    /**
     * Get pass
     *
     * @return array
     */
    public function getPass(): array
    {
        return $this->_pass;
    }

    /**
     * Get tls section
     *
     * @return array
     */
    public function getTls(): array
    {
        return $this->_tls;
    }

    /**
     * Get listener
     *
     * @return mixed
     */
    public function getListener()
    {
        return $this->_listener;
    }

    /**
     * Parse data from array
     *
     * @throws UnitException
     */
    public function parseFromArray(array $data): Listener
    {
        if (!array_key_exists('pass', $data)) {
            throw new UnitException("Missing required 'pass' array key");
        }

        $this->_pass = explode('/', $data['pass']);
        $this->_forwarded = $data['forwarded'] ?? [];
        $this->_tls = $data['tls'] ?? [];

        return $this;
    }
}

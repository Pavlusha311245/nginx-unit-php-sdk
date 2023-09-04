<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Config\Listener\Forwarded;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;

/**
 * This class presents "listeners" section from config
 */
class Listener
{
    /**
     * @var string
     */
    private string $_link;

    /**
     * @var ListenerPass
     */
    private ListenerPass $_pass;

    /**
     * @var int
     */
    private int $_port;

    public function __construct(
        private readonly string $_listener,
        string                  $pass,
        private array           $_tls = [],
        private ?Forwarded      $_forwarded = null,
    ) {
        $this->parsePort();
        $this->generateLink();

        $this->_pass = new ListenerPass($pass);
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
            "0.0.0.0:{$separatedListener[1]}" : $this->_listener;
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
     * @return ListenerPass
     */
    public function getPass(): ListenerPass
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

        if (array_key_exists('forwarded', $data)) {
            $this->_forwarded = new Forwarded($data['forwarded']);
        }

        $this->_tls = $data['tls'] ?? [];

        return $this;
    }

    /**
     * Return listener as array
     *
     * @return array
     */
    public function toArray(): array
    {
        $listenerArray = [
            'pass' => $this->_pass->toString(),
        ];

        if (!empty($this->_tls)) {
            $listenerArray['tls'] = $this->_tls;
        }

        if (!empty($this->_forwarded)) {
            $listenerArray['forwarded'] = $this->_forwarded;
        }

        return $listenerArray;
    }

    /**
     * Return Listener as JSON
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}

<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Config\Listener\{
    Forwarded,
    ListenerPass,
    Tls
};
use UnitPhpSdk\Exceptions\UnitException;

/**
 * This class presents "listeners" section from config
 */
class Listener
{
    /**
     * @var ListenerPass
     */
    private ListenerPass $pass;

//    TODO: implement From 1.30.0
//    private $response_headers

    /**
     * @var int
     */
    private int $port;

    public function __construct(
        private readonly string $listener,
        string|ListenerPass     $pass,
        private ?Tls            $tls = null,
        private ?Forwarded      $forwarded = null,
    )
    {
        $this->parsePort();

        if ($pass instanceof ListenerPass) {
            $this->pass = $pass;
        } else {
            $this->pass = new ListenerPass($pass);
        }
    }

    /**
     * Get link
     *
     * @param string $host
     * @return string
     */
    public function getLink(string $host = '127.0.0.1'): string
    {
        return $this->generateLink($host);
    }

    /**
     * Generate link from listener
     *
     * @param string $host
     * @return string
     */
    private function generateLink(string $host = '127.0.0.1'): string
    {
        $separatedListener = explode(':', $this->listener);

        $host = $separatedListener[0] == '*' ? "$host:$separatedListener[1]" : $this->listener;
        $secure = $this->isSecure() ? 'https' : 'http';

        return "$secure://$host";
    }

    /**
     * Check if listener has certificate
     *
     * @return bool
     */
    public function isSecure(): bool
    {
        return !empty($this->tls);
    }

    /**
     * Parse port
     *
     * @return void
     */
    private function parsePort(): void
    {
        $this->port = explode(':', $this->listener)[1];
    }

    /**
     * Get port
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Get forwarded
     *
     * @return Forwarded
     */
    public function getForwarded(): Forwarded
    {
        return $this->forwarded;
    }

    /**
     * Get pass
     *
     * @return ListenerPass
     */
    public function getPass(): ListenerPass
    {
        return $this->pass;
    }

    /**
     * @param ListenerPass $pass
     */
    public function setPass(ListenerPass $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * Get tls section
     *
     * @return Tls
     */
    public function getTls(): Tls
    {
        return $this->tls;
    }

    /**
     * Get listener
     *
     * @return string
     */
    public function getListener(): string
    {
        return $this->listener;
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
            $this->forwarded = new Forwarded($data['forwarded']);
        }

        if (array_key_exists('tls', $data)) {
            $this->tls = new Tls($data['tls']);
        }

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
            'pass' => $this->pass->toString(),
        ];

        if (!empty($this->tls)) {
            $listenerArray['tls'] = $this->tls->toArray();
        }

        if (!empty($this->forwarded)) {
            $listenerArray['forwarded'] = $this->forwarded->toArray();
        }

        return $listenerArray;
    }

    /**
     * @param Tls|null $tls
     */
    public function setTls(?Tls $tls): void
    {
        $this->tls = $tls;
    }

    /**
     * @param Forwarded|null $forwarded
     */
    public function setForwarded(?Forwarded $forwarded): void
    {
        $this->forwarded = $forwarded;
    }

    /**
     * Return Listener as JSON
     *
     * @return string|false
     */
    public function toJson(): string|false
    {
        return json_encode($this->toArray());
    }
}

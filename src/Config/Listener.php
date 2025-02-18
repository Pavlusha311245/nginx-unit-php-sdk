<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Config\Listener\{
    Forwarded,
    ListenerPass,
    Tls
};
use Override;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\Jsonable;
use UnitPhpSdk\Contracts\Uploadable;
use UnitPhpSdk\Enums\ApiPathEnum;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Traits\CanUpload;

/**
 * This class presents "listeners" section from config
 */
class Listener implements Uploadable, Arrayable, Jsonable
{
    use CanUpload;

    /**
     * @var ListenerPass
     */
    private ListenerPass $pass;

    /**
     *
     *
     * @var int
     */
    private int $port;

    public function __construct(
        private readonly string $listener,
        /**
         * Destination to which the listener passes incoming requests
         * @var string|ListenerPass
         */
        string|ListenerPass     $pass,
        /**
         * Defines SSL/TLS settings.
         * @var Tls|null
         */
        private ?Tls            $tls = null,
        /**
         * Configures client IP address and protocol replacement.
         * @var Forwarded|null
         */
        private ?Forwarded      $forwarded = null,
        /**
         * Controls the ‘backlog’ parameter to the listen(2) system-call.
         * This essentially limits the number of pending connections waiting to be accepted.
         * @var int
         */
        private ?int            $backlog = null
    )
    {
        $this->parsePort();
        $this->parsePass($pass);

        $this->setApiEndpoint(ApiPathEnum::LISTENER->getPath($this->getListener()));
    }

    /**
     * @param $pass
     * @return void
     */
    private function parsePass($pass): void
    {
        if (is_string($pass)) {
            parse_listener_pass($pass);
        }

        $this->pass = $pass instanceof ListenerPass ? $pass : new ListenerPass($pass);
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
     * @return Tls|null
     */
    public function getTls(): ?Tls
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
     * @return string
     */
    public function getName(): string
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
    #[\Override] public function toArray(): array
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
     * @param int $options
     * @return string
     */
    #[Override] public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function toUnitArray(): array
    {
        return [
            $this->getListener() => $this->toArray()
        ];
    }

    public function getTarget(): ListenerPass
    {
        return $this->getPass();
    }

    public function getBacklog(): ?int
    {
        return $this->backlog;
    }

    public function setBacklog(?int $backlog): void
    {
        $this->backlog = $backlog;
    }
}

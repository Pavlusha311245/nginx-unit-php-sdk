<?php

namespace UnitPhpSdk\Config\Listener;

use UnitPhpSdk\Exceptions\UnitException;

class Forwarded
{
    /**
     * Defines address-based patterns for trusted addresses.
     * Replacement occurs only if the source IP of the request is a match.
     * A special case here is the "unix" string; it matches any UNIX domain sockets.
     *
     * @var string|array
     */
    private string|array $_source;

    /**
     * Names the HTTP header fields to expect in the request.
     * They should use the X-Forwarded-For format where the value is a comma- or space-separated list of IPv4s or IPv6s.
     *
     * @var string|null
     */
    private ?string $_client_ip;

    /**
     * Defines the relevant HTTP header field to look for in the request.
     * Unit expects it to follow the X-Forwarded-Proto notation, with the field value itself being http, https, or on.
     *
     * @var string|null
     */
    private ?string $_protocol;

    /**
     * Controls how the client_ip fields are traversed
     *
     * @var bool
     */
    private bool $_recursive = false;

    /**
     * @throws UnitException
     */
    public function __construct(array $data)
    {
        $this->parseFromArray($data);
    }

    /**
     * @throws UnitException
     */
    private function parseFromArray(array $data): void
    {
        if (!array_key_exists('source', $data)) {
            throw new UnitException("Missing required 'source' array key");
        }

        $this->setSource($data['source']);

        if (array_key_exists('client_ip', $data)) {
            $this->setClientIp($data['client_ip']);
        }

        if (array_key_exists('protocol', $data)) {
            $this->setProtocol($data['protocol']);
        }

        if (array_key_exists('recursive', $data)) {
            $this->setRecursive($data['recursive']);
        }
    }

    /**
     * @param array|string $source
     */
    public function setSource(array|string $source): void
    {
        $this->_source = $source;
    }

    /**
     * @return array|string
     */
    public function getSource(): array|string
    {
        return $this->_source;
    }

    /**
     * @param string $protocol
     */
    public function setProtocol(string $protocol): void
    {
        $this->_protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->_protocol;
    }

    /**
     * @param string $client_ip
     */
    public function setClientIp(string $client_ip): void
    {
        $this->_client_ip = $client_ip;
    }

    /**
     * @return string
     */
    public function getClientIp(): string
    {
        return $this->_client_ip;
    }

    /**
     * @param bool $recursive
     */
    public function setRecursive(bool $recursive): void
    {
        $this->_recursive = $recursive;
    }

    /**
     * @return bool
     */
    public function isRecursive(): bool
    {
        return $this->_recursive;
    }

    public function toArray(): array
    {
        $data = [
            'source' => $this->_source,
        ];

        if (empty($this->_client_ip)) {
            $data['client_id'] = $this->getClientIp();
            $data['recursive'] = $this->isRecursive();
        }

        if (empty($this->_protocol)) {
            $data['protocol'] = $this->getProtocol();
        }

        return $data;
    }

    public function toJson(): false|string
    {
        return json_encode($this->toArray());
    }
}

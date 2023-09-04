<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Listener;

use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;

class Forwarded
{
    private string|array $_source;

    private string $_client_ip;

    private string $_protocol;

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
}

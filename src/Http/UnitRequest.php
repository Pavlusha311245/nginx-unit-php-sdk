<?php

namespace UnitPhpSdk\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use UnitPhpSdk\Exceptions\UnitException;

/**
 * TODO: make as DI container
 * Base class for requests
 */
class UnitRequest
{
    private string $method = 'GET';

    private mixed $data;

    /**
     * Nginx Unit address
     *
     * @var string
     */
    private readonly string $address;

    /**
     * Constructor
     *
     * @param string $address
     * @param string|null $socket
     */
    public function __construct(
        string                   $address,
        private readonly ?string $socket = null
    ) {
        $this->address = $this->parseAddress($address);
    }

    /**
     * @param string $address
     * @return string
     */
    private function parseAddress(string $address): string
    {
        $scheme = parse_url($address, PHP_URL_SCHEME);
        $host = parse_url($address, PHP_URL_HOST);
        $port = parse_url($address, PHP_URL_PORT);

        $address = "$scheme://$host";

        if ($port) {
            $address .= ":$port";
        }

        return $address;
    }

    /**
     * Set HTTP method
     *
     * @param mixed $method
     */
    public function setMethod(string $method): self
    {
        $this->method = mb_strtoupper($method);

        return $this;
    }

    /**
     * Send request
     *
     * @throws UnitException
     */
    public function send($uri, $associative = true, array $requestOptions = [])
    {
        $client = new Client();

        if (!empty($this->socket)) {
            $requestOptions['curl'] = [CURLOPT_UNIX_SOCKET_PATH => $this->socket];
        }

        try {
            $response = $client->request($this->method, $this->address . $uri, $requestOptions);
        } catch (GuzzleException $exception) {
            throw new UnitException($exception->getMessage());
        }

        $rawData = json_decode($response->getBody()->getContents(), $associative);

        if ($associative && array_key_exists('error', $rawData)) {
            throw new UnitException($rawData['error']);
        }

        $this->clean();

        return $rawData;
    }

    /**
     * Clear data after request
     *
     * @return void
     */
    private function clean(): void
    {
        $this->method = 'GET';
        $this->data = null;
    }
}

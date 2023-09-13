<?php

namespace UnitPhpSdk\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use UnitPhpSdk\Exceptions\UnitException;

/**
 * Base class for requests
 */
class UnitRequest
{
    private string $_method = 'GET';

    private mixed $_data;

    private readonly string $_address;

    /**
     * Constructor
     *
     * @param string $socket
     * @param string $address
     */
    public function __construct(
        private readonly string $socket,
        string                  $address
    ) {
        $scheme = parse_url($address, PHP_URL_SCHEME);
        $host = parse_url($address, PHP_URL_HOST);

        $this->_address = "{$scheme}://{$host}";
    }

    /**
     * Set HTTP method
     *
     * @param mixed $method
     */
    public function setMethod(string $method): void
    {
        $this->_method = mb_strtoupper($method);
    }

    /**
     * Setup data
     *
     * @param null $data
     */
    public function setData(mixed $data): void
    {
        $this->_data = $data;
    }

    /**
     * Send request
     *
     * @throws UnitException
     */
    public function send($uri, $associative = true)
    {
        $request = new Client([
            'base_uri' => $this->_address
        ]);

        $requestOptions = [
            'curl' => [
                CURLOPT_UNIX_SOCKET_PATH => $this->socket
            ]
        ];

        if (!empty($this->_data)) {
            $requestOptions['form_params'] = $this->_data;
        }

        try {
            $response = $request->request($this->_method, $uri, $requestOptions);
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
        $this->_method = 'GET';
        $this->_data = null;
    }
}

<?php

namespace Pavlusha311245\UnitPhpSdk;

use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;

class UnitRequest
{
    private string $_method = 'GET';

    private mixed $_data;

    /**
     * Constructor
     *
     * @param string $socket
     * @param string $address
     */
    public function __construct(
        private readonly string $socket,
        private readonly string $address
    ) {
        //
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
        $curlHandler = curl_init();

        curl_setopt($curlHandler, CURLOPT_UNIX_SOCKET_PATH, $this->socket);
        curl_setopt($curlHandler, CURLOPT_URL, $this->address . $uri);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);

        if ($this->_method) {
            curl_setopt($curlHandler, CURLOPT_CUSTOMREQUEST, mb_strtoupper($this->_method));
        }

        if (!empty($this->_data)) {
            curl_setopt($curlHandler, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);

            curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $this->_data);
        }

        $result = curl_exec($curlHandler);
        if (curl_errno($curlHandler)) {
            throw new UnitException('Error:' . curl_error($curlHandler));
        }
        curl_close($curlHandler);
        $this->clean();

        $rawData = json_decode($result, $associative);

        if ($associative) {
            if (array_key_exists('error', $rawData)) {
                throw new UnitException($rawData['error']);
            }
        }

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

<?php

namespace Pavlusha311245\UnitPhpSdk;

class UnitRequest
{
    private $_method = 'GET';

    private $_data = null;

    public function __construct(private string $socket, private string $address)
    {
        //
    }

    /**
     * @param mixed $method
     */
    public function setMethod(string $method): void
    {
        $this->_method = mb_strtoupper($method);
    }

    /**
     * @param null $data
     */
    public function setData($data): void
    {
        $this->_data = $data;
    }

    /**
     * @throws Exception
     */
    public function send($uri)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $this->socket);
        curl_setopt($ch, CURLOPT_URL, $this->address . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($this->_method) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, mb_strtoupper($this->_method));
        }

        if (!empty($this->_data)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
            ]);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_data);
        }

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception('Error:' . curl_error($ch));
        }
        curl_close($ch);

        return json_decode($result, true);
    }
}

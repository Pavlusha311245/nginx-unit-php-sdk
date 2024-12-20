<?php

namespace UnitPhpSdk\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class UnitHttpClient
{
    private ClientInterface $client;

    public function __construct(
        /**
         * Base URL for requests
         *
         * @var string
         */
        private readonly string  $baseUrl,
        private readonly ?string $socket = null,
        ?ClientInterface         $client = null
    ) {
        $this->client = $client ?? new Client([
            'base_uri' => $this->baseUrl,
            'curl' => $this->socket ? [
                CURLOPT_UNIX_SOCKET_PATH => $this->socket
            ] : []
        ]);
    }

    public function request(string $method, string $uri, array $options = [])
    {

    }

    //    /**
    //     * @param string $address
    //     * @return string
    //     */
    //    private function parseAddress(string $address): string
    //    {
    //        $scheme = parse_url($address, PHP_URL_SCHEME);
    //        $host = parse_url($address, PHP_URL_HOST);
    //        $port = parse_url($address, PHP_URL_PORT);
    //
    //        $address = "$scheme://$host";
    //
    //        if ($port) {
    //            $address .= ":$port";
    //        }
    //
    //        return $address;
    //    }
}

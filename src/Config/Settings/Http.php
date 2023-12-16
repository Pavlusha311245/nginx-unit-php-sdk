<?php

namespace UnitPhpSdk\Config\Settings;

class Http
{
    /**
     *
     * Maximum number of seconds to read data from the body of a client’s request.
     * This is the interval between consecutive read operations, not the time to read the entire body.
     * If Unit doesn’t receive any data from the client within this interval, it returns a 408 “Request Timeout” response.
     *
     * @var int
     */
    private int $body_read_timeout = 30;

    /**
     * Controls header field name parsing.
     * If it’s set to true, Unit only processes header names made of alphanumeric characters and hyphens (see RFC 9110);
     * otherwise, these characters are also permitted: .!#$%&'*+^_`|~.
     *
     * @var bool
     */
    private bool $discard_unsafe_fields = true;

    /**
     * Maximum number of seconds to read the header of a client’s request.
     * If Unit doesn’t receive the entire header from the client within this interval, it returns a 408 “Request Timeout” response.
     *
     * @var int
     */
    private int $header_read_timeout = 30;

    /**
     * Maximum number of seconds between requests in a keep-alive connection.
     * If no new requests arrive within this interval, Unit returns a 408 “Request Timeout” response and closes the connection.
     *
     * @var int
     */
    private int $idle_timeout = 180;

    /**
     * Enables or disables router logging.
     *
     * @var bool
     */
    private bool $log_route = false;

    /**
     * Maximum number of bytes in the body of a client’s request.
     * If the body size exceeds this value, Unit returns a 413 “Payload Too Large” response and closes the connection.
     *
     * @var int
     */
    private int $max_body_size = 8388608;

    /**
     *
     * Maximum number of seconds to transmit data as a response to the client.
     * This is the interval between consecutive transmissions, not the time for the entire response.
     * If no data is sent to the client within this interval, Unit closes the connection.
     *
     * @var int
     */
    private int $send_timeout = 30;

    /**
     * If set to false, Unit omits version information in its Server response header fields.
     *
     * @var bool
     */
    private bool $server_version = true;

    /**
     * @var
     */
    private mixed $static = null;

    /**
     * @return int
     */
    public function getBodyReadTimeout(): int
    {
        return $this->body_read_timeout;
    }

    /**
     * @return int
     */
    public function getHeaderReadTimeout(): int
    {
        return $this->header_read_timeout;
    }

    /**
     * @return int
     */
    public function getIdleTimeout(): int
    {
        return $this->idle_timeout;
    }

    /**
     * @return int
     */
    public function getMaxBodySize(): int
    {
        return $this->max_body_size;
    }


    /**
     * @return int
     */
    public function getSendTimeout(): int
    {
        return $this->send_timeout;
    }


    /**
     * @return mixed
     */
    public function getStatic()
    {
        return $this->static;
    }

    /**
     * @return bool
     */
    public function isDiscardUnsafeFields(): bool
    {
        return $this->discard_unsafe_fields;
    }

    /**
     * @return bool
     */
    public function isLogRoute(): bool
    {
        return $this->log_route;
    }

    /**
     * @return bool
     */
    public function isServerVersion(): bool
    {
        return $this->server_version;
    }
}

<?php

namespace UnitPhpSdk\Config\Settings;

class Http
{
    /**
     * @var int
     */
    private int $_body_read_timeout;

    /**
     * @var bool
     */
    private bool $_discard_unsafe_fields;

    /**
     * @var int
     */
    private int $_header_read_timeout;

    /**
     * @var int
     */
    private int $_idle_timeout;

    /**
     * @var bool
     */
    private bool $_log_route;

    /**
     * @var int
     */
    private int $_max_body_size;

    /**
     * @var int
     */
    private int $_send_timeout;

    /**
     * @var bool
     */
    private bool $_server_version;

    /**
     * @var
     */
    private $_static;
}

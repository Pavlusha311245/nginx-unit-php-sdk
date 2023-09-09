<?php

namespace UnitPhpSdk\Config;

use UnitPhpSdk\Interfaces\UpstreamInterface;
use UnitPhpSdk\Traits\HasListeners;

class Upstream implements UpstreamInterface
{
    use HasListeners;

    private array $_servers;

    public function __construct(
        private readonly string $_name,
        array                   $data
    ) {
        $this->_servers = $data;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @return array
     */
    public function getServers(): array
    {
        return $this->_servers['servers'];
    }
}

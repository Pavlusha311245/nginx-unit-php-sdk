<?php

namespace Pavlusha311245\UnitPhpSdk\Config;

use Pavlusha311245\UnitPhpSdk\Interfaces\UpstreamInterface;
use Pavlusha311245\UnitPhpSdk\Traits\HasListeners;

class Upstream implements UpstreamInterface
{
    use HasListeners;

    private array $_servers;

    public function __construct(
        private readonly string $_name,
        array                   $data)
    {
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
        return $this->_servers;
    }
}

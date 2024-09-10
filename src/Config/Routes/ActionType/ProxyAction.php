<?php

namespace UnitPhpSdk\Config\Routes\ActionType;

use Override;
use UnitPhpSdk\Contracts\Arrayable;

class ProxyAction implements Arrayable
{
    public function __construct(
        private string $proxy
    ) {
        $this->setProxy($proxy);
    }

    /**
     * @return string
     */
    public function getProxy(): string
    {
        return $this->proxy;
    }

    /**
     * @param string $proxy
     */
    public function setProxy(string $proxy): void
    {
        $this->proxy = $proxy;
    }


    #[Override] public function toArray(): array
    {
        return ['proxy' => $this->getProxy()];
    }
}

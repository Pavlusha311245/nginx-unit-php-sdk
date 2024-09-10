<?php

namespace UnitPhpSdk\Config\Routes\ActionType;

use Override;
use UnitPhpSdk\Contracts\Arrayable;

class PassAction implements Arrayable
{
    public function __construct(
        private string $pass
    ) {
        $this->setPass($pass);
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    #[Override] public function toArray(): array
    {
        return [
            'pass' => $this->getPass()
        ];
    }
}

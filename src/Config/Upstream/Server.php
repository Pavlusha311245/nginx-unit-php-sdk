<?php

namespace UnitPhpSdk\Config\Upstream;

use OutOfRangeException;
use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Exceptions\UnitException;

class Server implements Arrayable
{
    /**
     * @throws UnitException
     */
    public function __construct(
        private string $pass = '',
        private int    $weight = 1
    ) {
        if (!empty($pass)) {
            $this->validatePass($pass);
        }

        if (!empty($weight)) {
            $this->validateWeight($weight);
        }
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
     * @throws UnitException
     */
    public function setPass(string $pass): void
    {
        $this->validatePass($pass);

        $this->pass = $pass;
    }

    /**
     * @param string $pass
     * @return void
     * @throws UnitException
     */
    private function validatePass(string $pass): void
    {
        $parts = parse_url($pass);

        if (!filter_var($parts['host'], FILTER_VALIDATE_IP)) {
            throw new UnitException($parts['host'] . " isn't a valid IP address");
        }

        if ((int)$parts['port'] < 1 || (int)$parts['port'] > 65535) {
            throw new UnitException($parts['port'] . " isn't a valid port number (allowed range is 1 to 65535)");
        }
    }

    /**
     * @param int $weight
     * @return void
     */
    private function validateWeight(int $weight): void
    {
        if ($weight < 0 || $weight > 1000000) {
            throw new OutOfRangeException('Weight should be between 0 and 1000000');
        }
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->validateWeight($weight);

        $this->weight = $weight;
    }

    #[\Override] public function toArray(): array
    {
        return [
            $this->getPass() => [
                'weight' => $this->getWeight()
            ]
        ];
    }
}

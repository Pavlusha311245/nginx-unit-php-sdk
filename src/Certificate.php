<?php

namespace UnitPhpSdk;

use UnitPhpSdk\Contracts\CertificateInterface;

/**
 * Certificate class
 *
 * @implements CertificateInterface
 */
readonly class Certificate implements CertificateInterface
{
    public function __construct(
        private array           $_data,
        private readonly string $_name
    ) {
        //
    }

    /**
     * Return certificate name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->_data['key'];
    }

    /**
     * @inheritDoc
     */
    public function getChain(): array
    {
        return $this->_data['chain'];
    }

    /**
     * Return all certificate data as array
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }
}

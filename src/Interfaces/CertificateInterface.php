<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface CertificateInterface
{
    /**
     * Return certificate key
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Return certificate chain
     *
     * @return array
     */
    public function getChain(): array;
}

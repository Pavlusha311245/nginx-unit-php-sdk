<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

use Pavlusha311245\UnitPhpSdk\Certificate;
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;

interface UnitInterface
{
    /**
     * Return Unit socket
     *
     * @return string
     */
    public function getSocket(): string;

    /**
     * Return Unit address
     *
     * @return string
     */
    public function getAddress(): string;

    /**
     * Return full config uploaded on Nginx Unit
     *
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface;

    /**
     * Return Usage Statistics from Unit
     *
     * @return StatisticsInterface
     * @throws UnitException
     */
    public function getStatistics(): StatisticsInterface;

    /**
     * Return array of certificates uploaded on Unit
     *
     * @return array
     */
    public function getCertificates(): array;

    /**
     * Return Certificate object
     *
     * @param string $certificateName
     * @return CertificateInterface|null
     */
    public function getCertificate(string $certificateName): ?CertificateInterface;

    /**
     * Upload certificate to Unit server
     *
     * @param string $path
     * @param string $certificateName
     * @return bool
     * @throws UnitException
     */
    public function uploadCertificate(string $path, string $certificateName): bool;

    /**
     * Remove certificate on Unit server
     *
     * @param string $certificateName
     * @return bool
     * @throws UnitException
     */
    public function removeCertificate(string $certificateName): bool;

    /**
     * Remove all data from config
     *
     * @return bool
     */
    public function removeConfig(): bool;
}

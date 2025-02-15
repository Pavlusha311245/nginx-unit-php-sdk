<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Config;
use UnitPhpSdk\Exceptions\UnitException;

interface UnitInterface extends Arrayable, Jsonable
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
     * @throws UnitException
     */
    public function uploadCertificate(string $path, string $certificateName);

    /**
     * Return full config uploaded on Nginx Unit
     *
     * @return ConfigInterface
     */
    public function getConfig(): ConfigInterface;

    /**
     * Upload full file config
     *
     * @param string $path
     * @return bool
     */
    public function uploadConfigFromFile(string $path): bool;

    /**
     * Remove certificate on Unit server
     *
     * @param string $certificateName
     * @return bool
     * @throws UnitException
     */
    public function removeCertificate(string $certificateName): bool;

    /**
     * Retrieve the list of JavaScript modules.
     *
     * This method returns an array containing the names of all available JavaScript modules.
     *
     * @return array An array containing the names of JavaScript modules.
     */
    public function getJsModules(): array;

    /**
     * Sets the JavaScript modules in the system.
     *
     * @param array $js_modules An array of JavaScript modules to be set.
     * @return void
     */
    public function setJsModules(array $js_modules): void;

    /**
     * @inheritDoc
     */
    public function toArray(): array;

    /**
     * @inheritDoc
     */
    public function toJson(int $options = 0): string;
}

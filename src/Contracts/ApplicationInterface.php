<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Config\Application\ProcessManagement\ApplicationProcess;
use UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;
use UnitPhpSdk\Config\Application\ProcessManagement\RequestLimit;

interface ApplicationInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return array
     */
    public function getEnvironment(): array;

    /**
     * @param array $environment
     * @return void
     */
    public function setEnvironment(array $environment): void;

    /**
     * @return string
     */
    public function getGroup(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setGroup(string $name): void;

    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setUser(string $name): void;

    /**
     * @return ProcessIsolation|null
     */
    public function getIsolation(): ?ProcessIsolation;

    /**
     * @param ProcessIsolation $isolation
     * @return void
     */
    public function setIsolation(ProcessIsolation $isolation): void;

    /**
     * @return RequestLimit|null
     */
    public function getLimits(): ?RequestLimit;

    /**
     * @param RequestLimit $requestLimit
     * @return void
     */
    public function setLimits(RequestLimit $requestLimit): void;

    /**
     * @return ApplicationProcess|int|null
     */
    public function getProcesses(): ApplicationProcess|int|null;

    /**
     * @param ApplicationProcess|int $processes
     * @return void
     */
    public function setProcesses(ApplicationProcess|int $processes): void;

    /**
     * @return string
     */
    public function getStdErr(): string;

    /**
     * @param string $path
     * @return void
     */
    public function setStdErr(string $path): void;

    /**
     * @return string
     */
    public function getStdOut(): string;

    /**
     * @param string $path
     * @return void
     */
    public function setStdOut(string $path): void;

    /**
     * @return string
     */
    public function getWorkingDirectory(): string;

    /**
     * @param string $path
     * @return void
     */
    public function setWorkingDirectory(string $path): void;
}

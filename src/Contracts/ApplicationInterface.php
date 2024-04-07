<?php

namespace UnitPhpSdk\Contracts;

use UnitPhpSdk\Config\Application\ProcessManagement\ApplicationProcess;
use UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;
use UnitPhpSdk\Config\Application\ProcessManagement\RequestLimit;

interface ApplicationInterface
{
    /**
     * @return array
     */
    public function getEnvironment(): array;

    /**
     * @param array $environment
     * @return ApplicationInterface
     */
    public function setEnvironment(array $environment): self;

    /**
     * @return string
     */
    public function getGroup(): string;

    /**
     * @param string $name
     * @return ApplicationInterface
     */
    public function setGroup(string $name): self;

    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @param string $name
     * @return ApplicationInterface
     */
    public function setUser(string $name): self;

    /**
     * @return ProcessIsolation|null
     */
    public function getIsolation(): ?ProcessIsolation;

    /**
     * @param ProcessIsolation $isolation
     * @return ApplicationInterface
     */
    public function setIsolation(ProcessIsolation $isolation): self;

    /**
     * @return RequestLimit|null
     */
    public function getLimits(): ?RequestLimit;

    /**
     * @param RequestLimit $requestLimit
     * @return void
     */
    public function setLimits(RequestLimit $requestLimit): self;

    /**
     * @return ApplicationProcess|int|null
     */
    public function getProcesses(): ApplicationProcess|int|null;

    /**
     * @param ApplicationProcess|int $processes
     * @return void
     */
    public function setProcesses(ApplicationProcess|int $processes): self;

    /**
     * @return string
     */
    public function getStdErr(): string;

    /**
     * @param string $path
     * @return ApplicationInterface
     */
    public function setStdErr(string $path): self;

    /**
     * @return string
     */
    public function getStdOut(): string;

    /**
     * @param string $path
     * @return ApplicationInterface
     */
    public function setStdOut(string $path): self;

    /**
     * @return string
     */
    public function getWorkingDirectory(): string;

    /**
     * @param string $path
     * @return ApplicationInterface
     */
    public function setWorkingDirectory(string $path): self;
}

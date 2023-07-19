<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ApplicationProcess;
use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;
use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\RequestLimit;
use Pavlusha311245\UnitPhpSdk\Enums\ApplicationTypeEnum;

interface ApplicationInterface
{
    public function getType(): string;

    public function setType(string $type);

    public function getEnvironment(): array;

    public function setEnvironment(array $environment): void;

    public function getGroup(): string;

    public function setGroup(string $name): void;

    public function getUser(): string;

    public function setUser(string $name): void;

    public function getIsolation(): ?ProcessIsolation;

    public function setIsolation(ProcessIsolation $isolation): void;

    public function getLimits(): ?RequestLimit;

    public function setLimits(RequestLimit $requestLimit): void;

    public function getProcesses(): ApplicationProcess|int|null;

    public function setProcesses(ApplicationProcess|int $processes): void;

    public function getStdErr(): string;

    public function setStdErr(string $path): void;

    public function getStdOut(): string;

    public function setStdOut(string $path): void;

    public function getWorkingDirectory(): string;

    public function setWorkingDirectory(string $path): void;
}

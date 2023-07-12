<?php

namespace Pavlusha311245\UnitPhpSdk\Interfaces;

interface UnitInterface
{
    public function getSocket(): string;

    public function getAddress(): string;

    public function getConfig(): ConfigInterface;

    public function getStatistics(): StatisticsInterface;

    public function getCertificates(): array;
}

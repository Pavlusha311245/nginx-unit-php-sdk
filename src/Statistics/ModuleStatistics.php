<?php

namespace UnitPhpSdk\Statistics;

use UnitPhpSdk\Contracts\Arrayable;
use UnitPhpSdk\Contracts\ModuleStatisticsInterface;

class ModuleStatistics implements ModuleStatisticsInterface, Arrayable
{
    /**
     * @var string Language module version. If multiple versions are loaded, the list contains multiple items.
     */
    private string $version;

    /**
     * @var string Path to the language module file
     */
    private string $libPath;

    public function __construct(array $data)
    {
        $this->parseFromArray($data);
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     */
    public function getLibPath(): string
    {
        return $this->libPath;
    }

    public function parseFromArray(array $data)
    {
        if (!isset($data['version'])) {
            throw new \InvalidArgumentException('Version is required');
        }

        if (!isset($data['lib'])) {
            throw new \InvalidArgumentException('Lib is required');
        }

        $this->version = $data['version'];
        $this->libPath = $data['lib'];
    }

    /**
     * @inheritDoc
     */
    #[\Override] public function toArray(): array
    {
        return [
            'version' => $this->getVersion(),
            'lib' => $this->getLibPath()
        ];
    }
}

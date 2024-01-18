<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

use UnitPhpSdk\Contracts\Arrayable;

class Automount implements Arrayable
{
    /**
     * @var bool|null
     */
    private ?bool $language_deps;

    /**
     * @var bool|null
     */
    private ?bool $procfs;

    /**
     * @var bool|null
     */
    private ?bool $tmpfs;

    public function __construct(private readonly array $data)
    {
        if (array_key_exists('language_deps', $data)) {
            $this->setLanguageDeps($data['language_deps']);
        }

        if (array_key_exists('procfs', $data)) {
            $this->setProcfs($data['procfs']);
        }

        if (array_key_exists('tmpfs', $data)) {
            $this->setTmpfs($data['tmpfs']);
        }
    }

    /**
     * @return bool|null
     */
    public function getLanguageDeps(): ?bool
    {
        return $this->language_deps ?? null;
    }

    /**
     * @return bool|null
     */
    public function getProcfs(): ?bool
    {
        return $this->procfs ?? null;
    }

    /**
     * @return bool|null
     */
    public function getTmpfs(): ?bool
    {
        return $this->tmpfs ?? null;
    }

    /**
     * @param bool|null $language_deps
     */
    public function setLanguageDeps(?bool $language_deps): void
    {
        $this->language_deps = $language_deps;
    }

    /**
     * @param bool|null $procfs
     */
    public function setProcfs(?bool $procfs): void
    {
        $this->procfs = $procfs;
    }

    /**
     * @param bool|null $tmpfs
     */
    public function setTmpfs(?bool $tmpfs): void
    {
        $this->tmpfs = $tmpfs;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return [
            'language_deps' => $this->getLanguageDeps(),
            'procfs' => $this->getProcfs(),
            'tmpfs' => $this->getTmpfs(),
        ];
    }
}

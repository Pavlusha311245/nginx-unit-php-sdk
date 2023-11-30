<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement;

use UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation\{
    Automount,
    Cgroup,
    Gidmap,
    Namespaces,
    Uidmap
};
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Contracts\Arrayable;

/**
 * @implements Arrayable
 */
class ProcessIsolation implements Arrayable
{
    /**
     * @var Automount
     */
    private Automount $automount;

    /**
     * @var Cgroup
     */
    private Cgroup $cgroup;

    /**
     * @var Gidmap
     */
    private Gidmap $gidmap;

    /**
     * @var Namespaces
     */
    private Namespaces $namespaces;

    /**
     * @var string
     */
    private string $rootfs;

    /**
     * @var Uidmap
     */
    private Uidmap $uidmap;

    /**
     * @throws UnitException
     */
    public function __construct(array $data)
    {
        $this->parseFromArray($data);
    }

    /**
     * @param Automount $automount
     */
    public function setAutomount(Automount $automount): void
    {
        $this->automount = $automount;
    }

    /**
     * @return Automount
     */
    public function getAutomount(): Automount
    {
        return $this->automount;
    }

    /**
     * @param Cgroup $cgroup
     */
    public function setCgroup(Cgroup $cgroup): void
    {
        $this->cgroup = $cgroup;
    }

    /**
     * @return Cgroup
     */
    public function getCgroup(): Cgroup
    {
        return $this->cgroup;
    }

    /**
     * @param Gidmap $gidmap
     */
    public function setGidmap(Gidmap $gidmap): void
    {
        $this->gidmap = $gidmap;
    }

    /**
     * @return Gidmap
     */
    public function getGidmap(): Gidmap
    {
        return $this->gidmap;
    }

    /**
     * @param Uidmap $uidmap
     */
    public function setUidmap(Uidmap $uidmap): void
    {
        $this->uidmap = $uidmap;
    }

    /**
     * @return Uidmap
     */
    public function getUidmap(): Uidmap
    {
        return $this->uidmap;
    }

    /**
     * Return rootfs
     *
     * @return string
     */
    public function getRootfs(): string
    {
        return $this->rootfs;
    }

    /**
     * Set rootfs
     *
     * @param string $rootfs
     */
    public function setRootfs(string $rootfs): void
    {
        $this->rootfs = $rootfs;
    }

    /**
     * @param Namespaces $namespaces
     */
    public function setNamespaces(Namespaces $namespaces): void
    {
        $this->namespaces = $namespaces;
    }

    /**
     * @return Namespaces
     */
    public function getNamespaces(): Namespaces
    {
        return $this->namespaces;
    }

    /**
     * @throws UnitException
     */
    public function parseFromArray(array $data): void
    {
        if (array_key_exists('automount', $data)) {
            $this->setAutomount(new Automount($data['automount']));
        }

        if (array_key_exists('cgroup', $data)) {
            $this->setCgroup(new Cgroup($data['cgroup']));
        }

        if (array_key_exists('gidmap', $data)) {
            $this->setGidmap(new Gidmap($data['gidmap']));
        }

        if (array_key_exists('uidmap', $data)) {
            $this->setUidmap(new Uidmap($data['uidmap']));
        }

        if (array_key_exists('rootfs', $data)) {
            $this->setRootfs($data['rootfs']);
        }

        if (array_key_exists('namespaces', $data)) {
            $this->setNamespaces(new Namespaces($data['namespaces']));
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'automount' => $this->getAutomount(),
            'cgroup' => $this->getCgroup()->toArray(),
            'gidmap' => $this->getGidmap()->toArray(),
            'uidmap' => $this->getUidmap()->toArray(),
            'rootfs' => $this->getRootfs(),
            'namespaces' => $this->getNamespaces()->toArray()
        ];
    }
}

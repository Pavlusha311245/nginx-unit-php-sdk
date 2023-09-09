<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement;

use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation\{
    Automount,
    Cgroup,
    Gidmap,
    Namespaces,
    Uidmap
};
use Pavlusha311245\UnitPhpSdk\Exceptions\UnitException;
use Pavlusha311245\UnitPhpSdk\Interfaces\Arrayable;

class ProcessIsolation implements Arrayable
{
    /**
     * @var Automount
     */
    private Automount $_automount;

    /**
     * @var Cgroup
     */
    private Cgroup $_cgroup;

    /**
     * @var Gidmap
     */
    private Gidmap $_gidmap;

    /**
     * @var Namespaces
     */
    private Namespaces $_namespaces;

    /**
     * @var string
     */
    private string $_rootfs;

    /**
     * @var Uidmap
     */
    private Uidmap $_uidmap;

    public function __construct(array $data)
    {
        $this->parseFromArray($data);
    }

    /**
     * @param Automount $automount
     */
    public function setAutomount(Automount $automount): void
    {
        $this->_automount = $automount;
    }

    /**
     * @return Automount
     */
    public function getAutomount(): Automount
    {
        return $this->_automount;
    }

    /**
     * @param Cgroup $cgroup
     */
    public function setCgroup(Cgroup $cgroup): void
    {
        $this->_cgroup = $cgroup;
    }

    /**
     * @return Cgroup
     */
    public function getCgroup(): Cgroup
    {
        return $this->_cgroup;
    }

    /**
     * @param Gidmap $gidmap
     */
    public function setGidmap(Gidmap $gidmap): void
    {
        $this->_gidmap = $gidmap;
    }

    /**
     * @return Gidmap
     */
    public function getGidmap(): Gidmap
    {
        return $this->_gidmap;
    }

    /**
     * @param Uidmap $uidmap
     */
    public function setUidmap(Uidmap $uidmap): void
    {
        $this->_uidmap = $uidmap;
    }

    /**
     * @return Uidmap
     */
    public function getUidmap(): Uidmap
    {
        return $this->_uidmap;
    }

    /**
     * Return rootfs
     *
     * @return string
     */
    public function getRootfs(): string
    {
        return $this->_rootfs;
    }

    /**
     * Set rootfs
     *
     * @param string $rootfs
     */
    public function setRootfs(string $rootfs): void
    {
        $this->_rootfs = $rootfs;
    }

    /**
     * @param Namespaces $namespaces
     */
    public function setNamespaces(Namespaces $namespaces): void
    {
        $this->_namespaces = $namespaces;
    }

    /**
     * @return Namespaces
     */
    public function getNamespaces(): Namespaces
    {
        return $this->_namespaces;
    }

    public function parseFromArray(array $data)
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

<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement;

use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation\{
    Automount,
    Cgroup,
    Gidmap,
    Namespaces,
    Uidmap
};

class ProcessIsolation
{
    /**
     * @var Automount
     */
    private Automount $_automount;

    /**
     * @var Cgroup
     */
    private Cgroup $_cggroup;

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
}

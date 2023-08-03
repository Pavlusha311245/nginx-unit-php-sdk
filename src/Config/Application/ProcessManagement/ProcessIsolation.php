<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement;

use Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation\{Automount,
    Cgroup,
    Gidmap,
    Namespaces,
    Uidmap
};

class ProcessIsolation
{
    private Automount $_automount;
    private Cgroup $_cggroup;
    private Gidmap $_gidmap;
    private Namespaces $_namespaces;
    private string $_rootfs;
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

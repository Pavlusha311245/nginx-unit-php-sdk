<?php

namespace Pavlusha311245\UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

use Pavlusha311245\UnitPhpSdk\Interfaces\Arrayable;

readonly class Namespaces implements Arrayable
{
    private bool $_cgroup;
    private bool $_credential;
    private bool $_mount;
    private bool $_network;
    private bool $_pid;
    private bool $_uname;

    public function __construct(array $data)
    {
        if (array_key_exists('cgroup', $data)) {
            $this->setCgroup($data['cgroup']);
        }

        if (array_key_exists('credential', $data)) {
            $this->setCredential($data['credential']);
        }

        if (array_key_exists('mount', $data)) {
            $this->setMount($data['mount']);
        }

        if (array_key_exists('pid', $data)) {
            $this->setPid($data['pid']);
        }

        if (array_key_exists('network', $data)) {
            $this->setNetwork($data['network']);
        }

        if (array_key_exists('uname', $data)) {
            $this->setUname($data['uname']);
        }
    }

    public function toArray(): array
    {
        return [
            'cgroup' => $this->isCgroup(),
            'credential' => $this->isCredential(),
            'mount' => $this->isMount(),
            'pid' => $this->isPid(),
            'network' => $this->isNetwork(),
            'uname' => $this->isUname(),
        ];
    }


    /**
     * @param bool $uname
     */
    public function setUname(bool $uname): void
    {
        $this->_uname = $uname;
    }

    /**
     * @param bool $pid
     */
    public function setPid(bool $pid): void
    {
        $this->_pid = $pid;
    }

    /**
     * @param bool $network
     */
    public function setNetwork(bool $network): void
    {
        $this->_network = $network;
    }

    /**
     * @param bool $mount
     */
    public function setMount(bool $mount): void
    {
        $this->_mount = $mount;
    }

    /**
     * @param bool $credential
     */
    public function setCredential(bool $credential): void
    {
        $this->_credential = $credential;
    }

    /**
     * @param bool $cgroup
     */
    public function setCgroup(bool $cgroup): void
    {
        $this->_cgroup = $cgroup;
    }

    /**
     * @return bool
     */
    public function isCgroup(): bool
    {
        return $this->_cgroup;
    }

    /**
     * @return bool
     */
    public function isCredential(): bool
    {
        return $this->_credential;
    }

    /**
     * @return bool
     */
    public function isMount(): bool
    {
        return $this->_mount;
    }

    /**
     * @return bool
     */
    public function isNetwork(): bool
    {
        return $this->_network;
    }

    /**
     * @return bool
     */
    public function isPid(): bool
    {
        return $this->_pid;
    }

    /**
     * @return bool
     */
    public function isUname(): bool
    {
        return $this->_uname;
    }
}

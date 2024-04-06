<?php

namespace UnitPhpSdk\Config\Application\ProcessManagement\ProcessIsolation;

use UnitPhpSdk\Contracts\Arrayable;

/**
 * @readonly Namespaces
 * @implements Arrayable
 */
class Namespaces implements Arrayable
{
    /**
     * @var bool
     */
    private bool $cgroup = false;

    /**
     * @var bool
     */
    private bool $credential = false;

    /**
     * @var bool
     */
    private bool $mount = false;

    /**
     * @var bool
     */
    private bool $network = false;

    /**
     * @var bool
     */
    private bool $pid = false;

    /**
     * @var bool
     */
    private bool $uname = false;

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

    #[\Override] public function toArray(): array
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
        $this->uname = $uname;
    }

    /**
     * @param bool $pid
     */
    public function setPid(bool $pid): void
    {
        $this->pid = $pid;
    }

    /**
     * @param bool $network
     */
    public function setNetwork(bool $network): void
    {
        $this->network = $network;
    }

    /**
     * @param bool $mount
     */
    public function setMount(bool $mount): void
    {
        $this->mount = $mount;
    }

    /**
     * @param bool $credential
     */
    public function setCredential(bool $credential): void
    {
        $this->credential = $credential;
    }

    /**
     * @param bool $cgroup
     */
    public function setCgroup(bool $cgroup): void
    {
        $this->cgroup = $cgroup;
    }

    /**
     * @return bool
     */
    public function isCgroup(): bool
    {
        return $this->cgroup;
    }

    /**
     * @return bool
     */
    public function isCredential(): bool
    {
        return $this->credential;
    }

    /**
     * @return bool
     */
    public function isMount(): bool
    {
        return $this->mount;
    }

    /**
     * @return bool
     */
    public function isNetwork(): bool
    {
        return $this->network;
    }

    /**
     * @return bool
     */
    public function isPid(): bool
    {
        return $this->pid;
    }

    /**
     * @return bool
     */
    public function isUname(): bool
    {
        return $this->uname;
    }
}

<?php

namespace UnitPhpSdk\Config\Application\Options;

use UnitPhpSdk\Contracts\Arrayable;

class PhpOptions implements Arrayable
{
    /**
     * Pathname to the php.ini file
     *
     * @var string
     */
    private string $file = '';

    /**
     * Key-value
     *
     * @var array
     */
    private array $admin;

    /**
     * Key-value
     *
     * @var array
     */
    private array $user;

    /**
     * @return array
     */
    public function getAdmin(): array
    {
        return $this->admin ?? [];
    }

    /**
     * @param array $admin
     * @return PhpOptions
     */
    public function setAdmin(array $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return array
     */
    public function getUser(): array
    {
        return $this->user ?? [];
    }

    /**
     * @param array $user
     * @return PhpOptions
     */
    public function setUser(array $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return PhpOptions
     */
    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }


    /**
     * @return array
     */
    #[\Override] public function toArray(): array
    {
        return [
            'admin' => $this->getAdmin(),
            'user' => $this->getUser(),
            'file' => $this->getFile()
        ];
    }
}

<?php

namespace UnitPhpSdk\Abstract;

use UnitPhpSdk\Contracts\Arrayable;

/**
 * IDmap Abstract class
 */
class IdmapAbstract implements Arrayable
{
    /**
     * @var int
     */
    private int $container = 0;

    /**
     * @var int
     */
    private int $host = 0;

    /**
     * @var int
     */
    private int $size = 0;

    public function __construct(array $data)
    {
        $this->parseFromArray($data);
    }

    /**
     * Return container
     *
     * @return int
     */
    public function getContainer(): int
    {
        return $this->container;
    }

    /**
     * Return host
     *
     * @return int
     */
    public function getHost(): int
    {
        return $this->host;
    }

    /**
     * Return size
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $container
     */
    public function setContainer(int $container): void
    {
        $this->container = $container;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @param int $host
     */
    public function setHost(int $host): void
    {
        $this->host = $host;
    }

    /**
     * @param array $data
     * @return void
     */
    public function parseFromArray(array $data): void
    {
        if (array_key_exists('container', $data)) {
            $this->setContainer($data['container']);
        }

        if (array_key_exists('host', $data)) {
            $this->setHost($data['host']);
        }

        if (array_key_exists('size', $data)) {
            $this->setSize($data['size']);
        }
    }

    /**
     * @return array
     */
    #[\Override] public function toArray(): array
    {
        return [
            'container' => $this->getContainer(),
            'host' => $this->getHost(),
            'size' => $this->getSize()
        ];
    }
}

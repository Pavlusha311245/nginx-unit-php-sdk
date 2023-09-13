<?php

namespace UnitPhpSdk\Abstract;

class IdmapAbstract
{
    /**
     * @var int
     */
    private int $_container;

    /**
     * @var int
     */
    private int $_host;

    /**
     * @var int
     */
    private int $_size;

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
        return $this->_container;
    }

    /**
     * Return host
     *
     * @return int
     */
    public function getHost(): int
    {
        return $this->_host;
    }

    /**
     * Return size
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->_size;
    }

    /**
     * @param int $container
     */
    public function setContainer(int $container): void
    {
        $this->_container = $container;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->_size = $size;
    }

    /**
     * @param int $host
     */
    public function setHost(int $host): void
    {
        $this->_host = $host;
    }

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

    public function toArray()
    {
        return [
            'container' => $this->getContainer(),
            'host' => $this->getHost(),
            'size' => $this->getSize()
        ];
    }
}

<?php

namespace Pavlusha311245\UnitPhpSdk\Abstract;

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
}

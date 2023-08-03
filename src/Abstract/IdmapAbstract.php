<?php

namespace Pavlusha311245\UnitPhpSdk\Abstract;

class IdmapAbstract
{
    private int $_container;
    private int $_host;
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

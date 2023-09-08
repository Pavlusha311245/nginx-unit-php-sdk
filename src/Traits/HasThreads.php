<?php

namespace Pavlusha311245\UnitPhpSdk\Traits;

trait HasThreads
{
    private int $_threads;

    /**
     * @return int
     */
    public function getThreads(): int
    {
        return $this->_threads;
    }

    /**
     * @param int $threads
     */
    public function setThreads(int $threads): void
    {
        $this->_threads = $threads;
    }
}

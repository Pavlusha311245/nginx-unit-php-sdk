<?php

namespace Pavlusha311245\UnitPhpSdk\Traits;

trait HasThreads
{
    /**
     * Number of worker threads per app process.
     * When started, each app process creates this number of threads to handle requests
     *
     * @var int
     */
    private int $_threads = 1;

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

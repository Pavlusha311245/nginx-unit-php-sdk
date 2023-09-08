<?php

namespace Pavlusha311245\UnitPhpSdk\Traits;

trait HasThreadStackSize
{
    /**
     * Stack size of a worker thread
     *
     * @var int
     */
    private int $_thread_stack_size;

    /**
     * @return int
     */
    public function getThreadStackSize(): int
    {
        return $this->_thread_stack_size;
    }

    /**
     * @param int $thread_stack_size
     */
    public function setThreadStackSize(int $thread_stack_size): void
    {
        $this->_thread_stack_size = $thread_stack_size;
    }
}

<?php

namespace UnitPhpSdk\Traits;

trait HasThreadStackSize
{
    /**
     * Stack size of a worker thread
     *
     * @var int|null
     */
    private int|null $thread_stack_size;

    /**
     * @return int|null
     */
    public function getThreadStackSize(): int|null
    {
        return $this->thread_stack_size ?? null;
    }

    /**
     * @param int $thread_stack_size
     */
    public function setThreadStackSize(int $thread_stack_size): void
    {
        $this->thread_stack_size = $thread_stack_size;
    }
}

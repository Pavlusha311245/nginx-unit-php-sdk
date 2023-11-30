<?php

namespace UnitPhpSdk\Traits;

use UnitPhpSdk\Config\Listener;

trait HasListeners
{
    /**
     * Array of listeners
     *
     * @var array
     */
    private array $listeners = [];

    /**
     * Setup new listener
     *
     * @param Listener $listener
     * @return void
     */
    public function setListener(Listener $listener): void
    {
        $this->listeners[$listener->getListener()] = $listener;
    }

    /**
     * Get listeners linked to object;
     *
     * @return mixed
     */
    public function getListeners(): array
    {
        return $this->listeners;
    }

    /**
     * Check if listeners are empty or not
     *
     * @return bool
     */
    public function hasListeners(): bool
    {
        return !empty($this->listeners);
    }
}
